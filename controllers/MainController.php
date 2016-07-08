<?php

namespace app\controllers;

use app\models\AddForm;
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
        ];
    }

    /**
     *  --------------------------------------------- РЕГИСТРАЦИЯ ЧЕРЕЗ VKONTAKTE ---------------------------------------------------
     */
    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        $record = UserIdentity::findByVk_id($attributes["id"]);

//        echo "<br><pre>";print_r($attributes);echo "</pre>";die;

        if ($record) {
            //$record->token = ???        //token
        }
        else {
            $record = new Users();    //model
            $record->firstname = $attributes["first_name"];
            $record->lastname = $attributes["last_name"];
            $record->email = $attributes["email"];
            $record->vk_id = $attributes["id"];
            //$record->token = ???        //token
        }
        if ($record->save()) {
            Yii::$app->user->login(UserIdentity::findByVk_id($attributes["id"]), 3600 * 24 * 60);
            return $this->goBack();
        }
    }

    /**
     *  ------------------------------------------------- ГЛАВНАЯ СТРАНИЦА ----------------------------------------------------
     */
    public function actionIndex($tag = 'all', $sort = 1)
    {
        $activeTags = $tag;
        $sortName = 'date_publ';
        $completed = '';
        $activeLabelIdeaSort = $sort;

        //echo '<pre>';print_r($_GET);echo '</pre>';die; // for debag

        if ($sort == 2) {
            $sortName = 'like';
            $activeLabelIdeaSort = 2;
        }
        if ($sort == 3) {
            $sortName = 'completed';
            $completed = 'and completed = 1';
            $activeLabelIdeaSort = 3;
        }

//  ------ 1 вариант с 4 таблицами  ------
        $selectTag = $activeTags !== 'all' ? ' and t.name = "'.$activeTags.'"' : '';
        $query = (new Query())
            ->select('p.*, u.firstname')
            ->from('users u, posts p, tags t, tags_posts tp')
            ->where('p.user_id = u.id and p.id = tp.post_id and t.id = tp.tag_id '.$completed.$selectTag)
            ->distinct()
            ->orderBy($sortName.' desc');

//  ------ 2 вариант с двумя таблицами и ч/з like ------
//        $selectTag = $activeTags !== 'all' ? ' and tags like "%'.$activeTags.'%"' : '';
//        $query = (new Query())
//            ->select('posts.*, users.firstname')
//            ->from('users, posts')
//            ->where('posts.user_id = users.id '.$completed.$selectTag)
//            ->orderBy($sortName.' desc');

// ------- 3 вариант left joinaми ------
//        select distinct posts.*, users.firstname
//        from posts
//        left join tags_posts
//        on posts.id = tags_posts.post_id
//        left join users
//        on posts.user_id = users.id
//        left join tags
//        on tags.id = tags_posts.tag_id
//        where tags.name = 'Прочее'
//        order by date_publ desc

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);
        return $this->render('index', ['model' => $provider, 'activeLabelIdeaSort' => $activeLabelIdeaSort, 'activeTags' => $activeTags]);
    }


    /**
     *  -------------------------------------------------------- О НАС --------------------------------------------------------
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     *  ------------------------------------------------ РЕГИСТРАЦИЯ ЧЕРЕЗ FACEBOOK -------------------------------------------
     */
    public function actionFb()
    {
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId'          => '1758922991017571',
            'clientSecret'      => '7cf551bd21f3b3f02b6155dc7fa77e79',
            'redirectUri'       => 'http://idea.kr.ua.dev/main/fb',
            'graphApiVersion'   => 'v2.6',
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

        // Optional: Now you have a token you can look up a users profile data
        try {
            $user = $provider->getResourceOwner($token);

            $record = UserIdentity::findByFb_id($user->getId());

            if ($record)
                $record->token = $token->getToken();        //token
            else {
                $record = new Users();    //model
                $record->firstname = $user->getFirstName();
                $record->lastname = $user->getLastName();
                $record->email = $user->getEmail();
                $record->fb_id = $user->getId();
                $record->token = $token->getToken();        //token
            }
            if ($record->save()) {
                Yii::$app->user->login(UserIdentity::findByFb_id($user->getId()), 3600 * 24 * 60);
                return $this->goBack();
            }

         } catch (\Exception $e) {
            exit('Failed to get user details');
        }
    }

    /**
     *  ------------------------------------------------ ДОБАВЛЕНИЕ ИДЕИ ------------------------------------------------------
     */
    public function actionAddIdea()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('registration');
        }
        $model = new AddForm();

        //  ----  AJAX валидация  ----
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

        $tags = Tags::find('name')->select('name')->orderBy('id')->asArray()->all();
        $tags = ArrayHelper::getColumn($tags, 'name');

        return $this->render('add-idea', ['model' => $model, 'tags' => $tags]);
    }

    /**
     *  -------------------------------------------------- РЕГИСТРАЦИЯ ЧЕРЕЗ ФОРМУ -----------------------------------------------
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
}
