<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\analytic\ObjectAnalytic;
use app\components\arrangement\TemplatesManager;
use app\components\arrangement\TerritoryArrangementManager;
use app\components\arrangement\TerritoryConcept;
use app\components\coordinates\LocalCoordinatesManager;
use app\facades\TerritoryFacade;
use app\helpers\FuzzyLogicHelper;
use app\helpers\MathHelper;
use app\models\FuzzyIntervals;
use app\models\ObjectExtended;
use app\models\work\AgesWeightWork;
use app\models\work\ObjectWork;
use app\models\work\TerritoryWork;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    public function actionIndex()
    {
        $facade = Yii::createObject(TerritoryFacade::class);
        $matrixModel = $facade->generateTerritoryArrangement(TerritoryConcept::TYPE_BASE_WEIGHTS, 1, TerritoryFacade::OPTIONS_DEFAULT);
        $matrixModel->showMatrix(fopen('php://stdout', 'w'));

        $facade->correctArrangement(TerritoryConcept::TYPE_FULLNESS_MID);
        $facade->model->showMatrix(fopen('php://stdout', 'w'));
        var_dump ($facade->manager->territory->calculateCurrentFullness());
    }

    public function actionTest()
    {
        var_dump('lct2024task3');
        var_dump(md5('lct2024task3'));
        var_dump(md5('lct2024task3'));
    }

    public function actionAnalytic()
    {
        $targetObject = ObjectWork::find()->where(['id' => 15])->one();

        $analModel = new ObjectAnalytic();
        var_dump(ArrayHelper::getColumn($analModel->findSimilarObjects($targetObject, ObjectAnalytic::SIMILAR_TYPE_SLIGHTLY), 'id'));
    }

    public function actionTemplate()
    {

        $facade = Yii::createObject(TerritoryFacade::class);
        $matrixModel = $facade->generateTerritoryArrangement(TerritoryConcept::TYPE_BASE_WEIGHTS, 1, TerritoryFacade::OPTIONS_DEFAULT, 1);
        $facade->manager->template->showDebugTemplateMatrix(fopen('php://stdout', 'w'));
        $matrixModel->showMatrix(fopen('php://stdout', 'w'));
    }

    public function actionStr()
    {
        $territory = TerritoryWork::find()->where(['id' => 20])->one();

        $obj1 = new ObjectWork();
        $obj1->length = 250;
        $obj1->width = 150;
        $objExt1 = new ObjectExtended(
            $obj1,
            1,
            1,
            TerritoryConcept::HORIZONTAL_POSITION
        );

        $obj2 = new ObjectWork();
        $obj2->length = 150;
        $obj2->width = 150;
        $objExt2 = new ObjectExtended(
            $obj2,
            11,
            3,
            TerritoryConcept::HORIZONTAL_POSITION
        );

        $obj3 = new ObjectWork();
        $obj3->length = 150;
        $obj3->width = 50;
        $objExt3 = new ObjectExtended(
            $obj3,
            1,
            9,
            TerritoryConcept::HORIZONTAL_POSITION
        );

        $obj4 = new ObjectWork();
        $obj4->length = 150;
        $obj4->width = 50;
        $objExt4 = new ObjectExtended(
            $obj4,
            9,
            9,
            TerritoryConcept::VERTICAL_POSITION
        );

        var_dump(LocalCoordinatesManager::calculateLocalCoordinates($territory, $objExt1));
        var_dump(LocalCoordinatesManager::calculateLocalCoordinates($territory, $objExt2));
        var_dump(LocalCoordinatesManager::calculateLocalCoordinates($territory, $objExt3));
        var_dump(LocalCoordinatesManager::calculateLocalCoordinates($territory, $objExt4));
    }

    public function actionFixed()
    {
        $facade = Yii::createObject(TerritoryFacade::class);
        $facade->assemblyFixedArrangementByTerritoryId(5);

        $facade->model->showMatrix(fopen('php://stdout', 'w'));
    }
}
