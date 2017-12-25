<?php

namespace backend\controllers\shop;

use shop\forms\manage\shop\ProductForm;
use shop\services\manage\shop\ProductManageService;
use Yii;
use shop\entities\shop\product\Product;
use backend\forms\shop\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{

    public $service;

    public function __construct($id, $module, ProductManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function actionIndex()
    {
        $searchModel = new ProductSearch();
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
        $form = new ProductForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try {

                //print '<pre>'; print_r($form); print '</pre>';
                $product = $this->service->create($form);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {

                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);

    }


    public function actionUpdate($id)
    {
        $product = $this->findModel($id);
        $form = new ProductForm($product);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try {

                $this->service->edit($product->id, $form);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {

                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
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



}
