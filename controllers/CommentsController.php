<?php
namespace app\controllers;
use app\models\Comments;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\HttpException;
use yii\db\Query;
use yii\filters\VerbFilter;


class CommentsController extends \yii\web\Controller
{
    public function actionIndex($sort = 1)
    {
        $query = Comments ::find()->select('id, time, comment')->orderBy('time desc');
        if ($sort == 1)
            $query->andWhere('is_moderate = "0"');
        elseif ($sort == 2)
            $query->andWhere('is_moderate = "1"');

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);
        return $this->render('index', ['model' => $provider, 'activeLabelIdeaSort' => $sort]);
    }
    public function actionUpdate($id)
    {
        $model = Comments::findOne($id);
        $formData = Yii::$app->request->post();
        if ($formData[Comments][comment] != "" ) {
            $model->comment = $formData[Comments][comment];
            $model->is_moderate = 1;
            $model->save();
            
            return $this->redirect(['index', 'id' => $id]);
        } else {

            return $this->render('update', [
                'model' => $model,1
            ]);
        }
    }
    protected function findModel($id)
    {
        if (($model = Comments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // delete unused tags
        Yii::$app->db->createCommand('
              delete from comments where id = '.$id
        )->execute();

        return $this->redirect(['comments/index']);
    }


}