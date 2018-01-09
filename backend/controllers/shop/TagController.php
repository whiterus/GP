<?php

namespace backend\controllers\shop;

use shop\forms\manage\shop\TagForm;
use shop\services\manage\shop\TagManageService;
use Yii;
use shop\entities\shop\Tag;
use backend\forms\shop\TagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
{

    public $service;

    public function __construct($id, $module, TagManageService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
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
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new TagForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try{
                $tag = $this->service->create($form);
                return $this->redirect(['view', 'id' => $tag->id]);
            } catch (\DomainException $e){
                Yii::$app->session->setFlash('error', $e->getMessage() );
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $tag = $this->findModel($id);
        $form = new TagForm($tag);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try{
                $this->service->edit($tag->id, $form);
                return $this->redirect(['view', 'id' => $tag->id]);
            }
            catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage() );
            }
        }

        return $this->render('update', [
            'model' => $form,
            'tag' => $tag,
        ]);
    }

    /**
     * Deletes an existing Tag model.
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
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
