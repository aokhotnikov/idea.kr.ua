<?php

namespace app\controllers;

use app\models\Tags;
use app\models\TagsPosts;
use Yii;
use app\models\Posts;
use yii\db\Query;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) {
                return true;
            }
            throw new HttpException(404 ,'Page not found');
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $formData = Yii::$app->request->post('Posts');

            TagsPosts::deleteAll(['post_id' => $id]);  // delete relations in the table "tags_posts"

            // add new tags
            if ($formData['tagz']) {
                $masTags = $formData['tagz'];
                foreach ($masTags as $tag) {
                    $query = Tags::find()->where(['name' => $tag])->one();
                    $tag_id = $query["id"];
                    if (!$tag_id) { // если в таблице "Tags" нет такого тега
                        //echo '<pre>';print_r($query);echo '</pre>';die; // for debag
                        $model = new Tags();
                        $model->name = $tag;
                        $model->save(); //save new tag
                        $tag_id = $model->id;
                    }
                    // add new relations
                    $modelTagsPosts = new TagsPosts();
                    if (!$modelTagsPosts->insertRecord($id, $tag_id)) {
                        echo 'I can not insert data into the table';
                    }
                }
            }

            // delete unused tags
            Yii::$app->db->createCommand('
              delete from tags where id not in (
                select distinct tag_id from tags_posts
              )'
            )->execute();

            return $this->redirect(['view', 'id' => $id]);
        } else {

            $query = (new Query())
                ->select('t.name')
                ->from('tags t, tags_posts tp')
                ->where('t.id = tp.tag_id')
                ->andWhere('tp.post_id = '.$id)->all();

            return $this->render('update', [
                'model' => $model,
                'tags' => $query,
                'allTags' => Tags::find('name')->all()
            ]);
        }
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // delete unused tags
        Yii::$app->db->createCommand('
              delete from tags where id not in (
                select distinct tag_id from tags_posts
              )'
        )->execute();

        return $this->redirect(['admin/index']);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);
        //echo '<pre>';print_r($this->findModel($id));echo '</pre>';die; // for debag
        $model->status = $status ? 'isApproved' : 'isRejected';

        if ($model->save())
            return $this->redirect(['view', 'id' => $model->id]);
        else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }
}
