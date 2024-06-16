<?php

namespace app\controllers\backend;

use app\components\arrangement\TemplatesManager;
use app\components\arrangement\TerritoryConcept;
use app\components\coordinates\LocalCoordinatesManager;
use app\facades\TerritoryFacade;
use app\helpers\XmlHelper;
use app\models\forms\AnalyticModel;
use app\models\forms\demo\GenerateAnalogForm;
use app\models\forms\demo\GenerateByParamsForm;
use app\models\forms\DownloadXMLForm;
use app\models\ObjectExtended;
use app\models\work\ObjectWork;
use app\models\work\TerritoryWork;
use app\models\search\SearchTerritoryWork;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TerritoryController implements the CRUD actions for TerritoryWork model.
 */
class DemoController extends Controller
{
    private TemplatesManager $template;
    private TerritoryFacade $facade;

    public function __construct($id, $module, TemplatesManager $template, TerritoryFacade $facade, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->template = $template;
        $this->facade = $facade;
    }

    public function actionGenerateTemplateAjax($tId)
    {
        $this->facade->generateTerritoryArrangement(TerritoryConcept::TYPE_BASE_WEIGHTS, 1, TerritoryFacade::OPTIONS_DEFAULT, $tId);
        $this->facade->correctArrangement();

        $matrix = $this->facade->getRawMatrix();
        $objectsList = $this->facade->model->objectsPosition;
        $resultObjList = [];
        $maxHeight = 0;

        $territory = TerritoryWork::find()->where(['id' => 1])->one();

        foreach ($objectsList as $objectExt) {
            /** @var ObjectExtended $objectExt */
            if ($maxHeight < $objectExt->object->height) {
                $maxHeight = $objectExt->object->height;
            }

            $resultObjList[] = [
                'id' => $objectExt->object->id,
                'height' => ObjectWork::convertDistanceToCells($objectExt->object->height, TerritoryConcept::STEP),
                'width' => ObjectWork::convertDistanceToCells($objectExt->object->width, TerritoryConcept::STEP),
                'length' => ObjectWork::convertDistanceToCells($objectExt->object->length, TerritoryConcept::STEP),
                'rotate' => $objectExt->positionType == TerritoryConcept::HORIZONTAL_POSITION ? TerritoryConcept::HORIZONTAL_POSITION : 90,
                'link' => $objectExt->object->model_path,
                'dotCenter' => [
                    'x' => LocalCoordinatesManager::calculateLocalCoordinates($territory, $objectExt)['x'],
                    'y' => LocalCoordinatesManager::calculateLocalCoordinates($territory, $objectExt)['y'],
                ],
            ];
        }

        return json_encode(
            [
                'result' => [
                    'matrixCount' => [
                        'width' => count($matrix[0]),
                        'height' => count($matrix),
                        'maxHeight' => ObjectWork::convertDistanceToCells($maxHeight, TerritoryConcept::STEP),
                    ],
                    'matrix' => $matrix,
                    'objects' => $resultObjList,
                ],
                'analytic' => [
                    'data' => $this->facade->getAnalyticData(),
                ],
            ],
        );
    }

    public function actionGenerate()
    {
        $model = new GenerateByParamsForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->facade->generateTerritoryArrangement(
                TerritoryConcept::TYPE_SELF_VOTES,
                21,
                $model->addGenerateType,
                null,
                [
                    'votes' =>
                    [
                        ObjectWork::TYPE_RECREATION => $model->recreation * 10,
                        ObjectWork::TYPE_SPORT => $model->sport * 10,
                        ObjectWork::TYPE_EDUCATION => $model->education * 10,
                        ObjectWork::TYPE_GAME => $model->game * 10,
                    ]
                ]
            );

            $this->facade->correctArrangement($model->fullness);

            Yii::$app->session->set('facade', serialize($this->facade));

            $modelAnal = new AnalyticModel();
            $modelAnal->fill($this->facade->model);
            $modelAnal->fillAdd($this->facade->model, TerritoryWork::findOne(['id' => 21]));

            return $this->render('generate', [
                'model' => $model,
                'modelAnal' => $modelAnal,
                'data' => $this->facade->model->getDataForScene(1),
            ]);

        }

        return $this->render('generate', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        Yii::$app->session->set('header-active', 'demo');

        return $this->render('index');
    }

    public function actionAnalog()
    {
        $model = new GenerateAnalogForm();

        $data = '';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $arMatrix = $this->facade->assemblyFixedArrangementByTerritoryId($model->analogTerritoryId);
            $originalFullness = $this->facade->manager->territory->calculateCurrentFullness();

            $modelAnal1 = new AnalyticModel();
            $modelAnal1->fill($this->facade->model);
            $modelAnal1->uploadFlag = false;

            $this->facade->generateTerritoryArrangement(
                TerritoryConcept::TYPE_BASE_WEIGHTS,
                $model->analogTerritoryId,
                TerritoryFacade::OPTIONS_SIMILAR,
                null,
                ['arrangement' => $arMatrix->objectsPosition]);

            $this->facade->correctArrangement(
                $model->fullness,
                $model->fullness == TerritoryConcept::TYPE_FULLNESS_ORIGINAL ? ['originalFullness' => $originalFullness] : []);

            Yii::$app->session->set('facade', serialize($this->facade));

            $modelAnal2 = new AnalyticModel();
            $modelAnal2->fill($this->facade->model);

            return $this->render('analog', [
                'model' => $model,
                'modelAnal1' => $modelAnal1,
                'modelAnal2' => $modelAnal2,
                'data' => $this->facade->model->getDataForScene($model->analogTerritoryId),
            ]);
        }

        return $this->render('analog', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionRenderArrangementAjax($territoryId)
    {
        if (!$territoryId) {
            return json_encode(['status' => 'error']);
        }
        $this->facade->assemblyFixedArrangementByTerritoryId($territoryId);
        return $this->facade->model->getDataForScene($territoryId);
    }

    public function actionUploadXml()
    {


        if (Yii::$app->session->has('facade')) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment; filename="filename.xml"');

            $facade = unserialize(Yii::$app->session->get('facade'));
            echo XmlHelper::generateArrangementFile($facade->model);

            exit();
        }

        return false;

    }
}
