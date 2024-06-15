<?php

namespace app\controllers\backend;

use app\components\arrangement\TerritoryConcept;
use app\facades\TerritoryFacade;
use app\helpers\XmlHelper;
use app\models\forms\DownloadXMLForm;
use app\models\work\ObjectWork;
use app\models\search\SearchObjectWork;
use bupy7\xml\constructor\XmlConstructor;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ObjectController implements the CRUD actions for ObjectWork model.
 */
class ObjectController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ObjectWork models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchObjectWork();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ObjectWork model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ObjectWork model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ObjectWork();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ObjectWork model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ObjectWork model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUploadXml()
    {
        header('Content-Type: text/xml');
        header('Content-Disposition: attachment; filename="filename.xml"');

        //$facade = Yii::createObject(TerritoryFacade::class);
        //$matrixModel = $facade->generateTerritoryArrangement(TerritoryConcept::TYPE_BASE_WEIGHTS, 1, TerritoryFacade::OPTIONS_DEFAULT);
        echo XmlHelper::generateObjectsListFile(ObjectWork::find()->all());
        //echo XmlHelper::generateArrangementFile($facade->model);

        exit();
    }

    public function actionDownloadXml()
    {
        $model = new DownloadXMLForm();

        if (Yii::$app->request->isPost) {
            $model->xmlFile = UploadedFile::getInstance($model, 'xmlFile');

            if ($model->importXml()) {
                Yii::$app->session->setFlash('success', 'Данные из XML-файла успешно загружены');
                return $this->redirect(['index']);
            }
        }

        return $this->render('download-xml', ['model' => $model]);
    }

    /**
     * Finds the ObjectWork model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ObjectWork the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ObjectWork::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
