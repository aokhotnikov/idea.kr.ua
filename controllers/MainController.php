<?php

namespace app\controllers;

use app\models\AddForm;
use app\models\EmailForm;
use app\models\Posts;
use app\models\RegForm;
use app\models\Tags;
use app\models\UserIdentity;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;


class MainController extends Controller
{
    public function actions()
    {
        return [
            'auth' => [     // action -> /main/auth?authclient=vkontakte
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     *  --------------------------------------------- REGISTRATION WITH VKONTAKTE -------------------------------------------------
     */
    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        $record = UserIdentity::findByVk_id($attributes["id"]);

        //echo "<br><pre>";print_r($attributes);echo "</pre>";die;

        if (!$record) {

            $record = UserIdentity::findByEmail($attributes["email"]);

            if ($record) {
                $record->vk_id = $attributes["id"];
            }else{
                $record = new Users();    //model
                $record->firstname = $attributes["first_name"];
                $record->lastname = $attributes["last_name"];
                $record->email = $attributes["email"] ? $attributes["email"] : $attributes["id"].'@idea.net';
                $record->vk_id = $attributes["id"];
            }
        }
        //$record->token = ???        //token
        if ($record->save()) {
            Yii::$app->user->login(UserIdentity::findByVk_id($attributes["id"]), 3600 * 24 * 60);
            return $this->goBack();
        }
    }

    /**
     *  ------------------------------------------------ REGISTRATION WITH FACEBOOK -------------------------------------------
     */
    public function actionFb()
    {
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' => '1758922991017571',
            'clientSecret' => '7cf551bd21f3b3f02b6155dc7fa77e79',
            'redirectUri' => 'http://idea.kr.ua.dev/main/fb',
            'graphApiVersion' => 'v2.6',
        ]);

        $session = Yii::$app->session;

        if (!isset($_GET['code'])) {   // If we don't have an authorization code then get one

            $authUrl = $provider->getAuthorizationUrl([
                'scope' => ['email', 'public_profile'],
            ]);
            $session['oauth2state'] = $provider->getState();
            return $this->redirect($authUrl);

        } elseif (empty($_GET['state']) || ($_GET['state'] !== $session['oauth2state'])) {         // Check given state against previously stored one to mitigate CSRF attack
            unset($session['oauth2state']);
            echo 'Invalid state.';
            exit;
        }

        // Try to get an access token (using the authorization code grant)
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        //echo date("m.d.y", $token->getExpires());

        try {
            $user = $provider->getResourceOwner($token);

            $record = UserIdentity::findByFb_id($user->getId());

            if (!$record){

                $record = UserIdentity::findByEmail($user->getEmail());

                if ($record) {
                    $record->fb_id = $user->getId();
                }else {

                    $record = new Users();    //model
                    $record->firstname = $user->getFirstName();
                    $record->lastname = $user->getLastName();
                    $record->email = $user->getEmail() ? $user->getEmail() : $user->getId().'@idea.net';
                    $record->fb_id = $user->getId();
                }
            }
            $record->token = $token->getToken();        //token
            if ($record->save()) {
                Yii::$app->user->login(UserIdentity::findByFb_id($user->getId()), 3600 * 24 * 60);
                return $this->goBack();
            }

        } catch (\Exception $e) {
            exit('Failed to get user details');
        }
    }

    /**
     *  -------------------------------------------------- REGISTRATION WITH FORM -----------------------------------------------
     */
    public function actionRegistration()
    {
        $model = new RegForm();

        //  ----  AJAX валидация  ----
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {//пришли POST данные
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //echo '<pre>';print_r($_POST);echo '</pre>';die; // for debag

            $record = new Users();//model
            $formData = Yii::$app->request->post("RegForm");
            if ($record->insertRecord($formData)) {
                Yii::$app->session->setFlash('registrationSubmitted'); //Flash message
                return $this->refresh();
            }

            return $this->goBack();
        }
        return $this->render('registration', ['model' => $model]);
    }

    /**
     *  ---------------------------------------------------- MAIN PAGE -------------------------------------------------------
     */
    public function actionIndex($tag = 'all', $sort = 1)
    {
        $query = (new Query())
            ->select(['p.*', 'u.firstname', "GROUP_CONCAT(DISTINCT t.name ORDER BY t.name ASC SEPARATOR ',') as tags",
                     "(select count(*) from comments_posts cp where cp.post_id = p.id) as comments", '(p.like - p.dislike) as rating'])
            ->from('users u, posts p, tags t, tags_posts tp')
            ->where('p.user_id = u.id and p.id = tp.post_id and t.id = tp.tag_id')
            ->andWhere('p.status = "isApproved"')
            ->groupBy('p.id');

        if ($tag !== 'all') {
            $query->andWhere('t.name = "' . $tag . '"');
        }

        if ($sort == 1)
            $query->addOrderBy('date_publ desc');
        elseif ($sort == 2)
            $query->addOrderBy('rating desc');
        elseif ($sort == 3) {
            $query->andWhere('p.completed = 1');
            $query->addOrderBy('completed desc');
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);
        return $this->render('index', ['model' => $provider, 'activeLabelIdeaSort' => $sort, 'activeTags' => $tag]);
    }


    /**
     *  --------------------------------------------------------- ABOUT ---------------------------------------------------------
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     *  ------------------------------------------------------- ADD IDEA --------------------------------------------------------
     */
    public function actionAddIdea()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('registration');
        }else if (Yii::$app->user->identity->banned){
            return $this->goHome();
        }
        $model = new AddForm();

        //  ---- if AJAX валидация  ----
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {//пришли POST данные
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //echo '<pre>';print_r($_POST);echo '</pre>';die; // for debag

            $record = new Posts();//model
            $formData = Yii::$app->request->post("AddForm");
            if ($record->insertRecord($formData)) {
                Yii::$app->session->setFlash('ideaAddSubmitted'); //Flash message
                return $this->refresh();
            }
        }

        $tags = ArrayHelper::map(Tags::find('name')->all(), 'name', 'name');

        return $this->render('add-idea', ['model' => $model, 'tags' => $tags]);
    }

    public function actionAddEmail()
    {
        $model = new EmailForm();

        //  ----  AJAX валидация  ----
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post())) {//пришли POST данные
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->checkAddEmail()) {
            return $this->refresh();
        }

        return $this->goHome();
    }

}
