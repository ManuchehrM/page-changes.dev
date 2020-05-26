<?php

namespace app\controllers;

use app\models\Log;
use Yii;
use app\models\Page;
use app\models\PageSearch;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();

        if ($model->load(Yii::$app->request->post())) {
            $previewFile = UploadedFile::getInstance($model, 'preview');
            $model->created_by = Yii::$app->user->id;
            if(!empty($previewFile)){
                $path = Yii::getAlias('@webroot');
                $fileName = time().'_'.Yii::$app->user->id.'.'.$previewFile->extension;
                $previewFile->saveAs($path.'/uploads/preview/'.$fileName);
                $model->preview = $fileName;
            }
            if($model->save() && $model->saveTrigger()){
                \Yii::$app->session->setFlash('success', 'Страница успешно сохранено!');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //TODO log description and create log filter
        $model = $this->findModel($id);
        $updateDescription = new Log();
        $oldFile = $model->preview;
        if ($model->load(Yii::$app->request->post()) && $updateDescription->load(Yii::$app->request->post())) {
            $previewFile = UploadedFile::getInstance($model, 'preview');
            if(!empty($previewFile)){
                $path = Yii::getAlias('@webroot');
                $fileName = time().'_'.Yii::$app->user->id.'.'.$previewFile->extension;
                $previewFile->saveAs($path.'/uploads/preview/'.$fileName);
                $model->preview = $fileName;
            }else{
                $model->preview = $oldFile;
            }
            $model->updateTrigger($model, $updateDescription->update_description);
            $model->updated_at = new Expression('NOW()');
            $model->updated_by = Yii::$app->user->id;
            if($model->save()){
                \Yii::$app->session->setFlash('success', 'Страница успешно обновлено!');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'updateDescription' => $updateDescription
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
