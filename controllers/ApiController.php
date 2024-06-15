<?php

namespace app\controllers;

use app\facades\TerritoryFacade;
use app\helpers\ApiHelper;
use app\models\common\ObjectT;
use app\models\common\User;
use app\models\work\AgesWeightChangeableWork;
use app\models\work\ObjectWork;
use app\models\work\TerritoryWork;
use app\services\ApiService;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class ApiController extends Controller
{
    private ApiService $service;

    public function __construct($id, $module, ApiService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionDoc()
    {
        Yii::$app->session->set('header-active', 'api');

        return $this->render('doc');
    }

    /**
     * Возвращает список всех МАФ, удовлетворяющих условиям в формате JSON
     * @param int $type ограничение по типу объектов
     * @param int $minCost ограничение по минимальной стоимости МАФ
     * @param int $maxCost ограничения по максимальной стоимости МАФ
     * @param string $style ограничения по стилю МАФ
     * @return false|string
     */
    public function actionGetObjects($type = null, $minCost = null, $maxCost = null, $style = null)
    {
        if (!$this->service->checkKey(ApiHelper::TEST_API_KEY)) {
            return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Incorrect API key']);
        }

        $query = ObjectWork::find();

        if ($type !== null) {
            $query->andWhere(['object_type_id' => $type]);
        }

        if ($minCost !== null) {
            $query->andWhere(['>=', 'cost', $minCost]);
        }

        if ($maxCost !== null) {
            $query->andWhere(['<=', 'cost', $maxCost]);
        }

        if ($style !== null) {
            $query->andWhere(['style' => $style]);
        }

        $data['result'] = ApiHelper::STATUS_SUCCESS;
        foreach ($query->all() as $item) {
            $data['data'][] = $item->attributes;
        }

        return json_encode($data);
    }

    /**
     * Возвращает список дворовых территорий
     * @return array|false|string
     */
    public function actionGetTerritories()
    {
        if (!$this->service->checkKey(ApiHelper::TEST_API_KEY)) {
            return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Incorrect API key']);
        }

        $query = TerritoryWork::find();

        $data['result'] = ApiHelper::STATUS_SUCCESS;
        foreach ($query->all() as $item) {
            $data['data'][] = $item->attributes;
        }

        return $data;
    }

    /**
     * Возвращает список измененных весов по возрастам, с учетом заданных параметров
     * @param $tId
     * @param $weightType
     * @param $agesInterval
     * @return array
     */
    public function actionGetRealWeights($tId, $weightType = null, $agesInterval = null)
    {
        if (!$this->service->checkKey(ApiHelper::TEST_API_KEY)) {
            return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Incorrect API key']);
        }

        $query = AgesWeightChangeableWork::find()->where(['territory_id' => $tId]);

        if ($agesInterval !== null) {
            $query = $query->andWhere(['ages_interval_id' => $agesInterval]);
        }

        $data['result'] = ApiHelper::STATUS_SUCCESS;
        foreach ($query->all() as $item) {
            $data['data'][] = $item->attributes;
        }

        return $data;
    }

    public function actionGenerateArrangement($tId, $genType, $addGenType = TerritoryFacade::OPTIONS_DEFAULT, $params = [])
    {
        if (!$this->service->checkKey(ApiHelper::TEST_API_KEY)) {
            return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Incorrect API key']);
        }

        $facade = Yii::createObject(TerritoryFacade::class);
        $facade->generateTerritoryArrangement($genType, $tId, $addGenType, $params);

        return json_encode($facade->getRawMatrix());
    }

    public function actionLoadTerritory()
    {
        if (!$this->service->checkKey(ApiHelper::TEST_API_KEY)) {
            return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Incorrect API key']);
        }

        if ($request = Yii::$app->request->post()) {
            $territory = new TerritoryWork();
            $territory->width = $request['width'];
            $territory->length = $request['length'];
            $territory->name = $request['name'];
            $territory->address = $request['address'];
            $territory->latitude = $request['latitude'];
            $territory->longitude = $request['longitude'];
            if ($territory->save()) {
                return json_encode(['result' => ApiHelper::STATUS_SUCCESS, 'id' => $territory->id]);
            }
            else {
                return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Saving error, try again']);
            }
        }
        else {
            return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Incorrect query type. Use POST type']);
        }
    }

    public function actionLoadObject()
    {
        if (!$this->service->checkKey(ApiHelper::TEST_API_KEY)) {
            return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Incorrect API key']);
        }

        if ($request = Yii::$app->request->post()) {
            $object = new ObjectWork();
            $object->name = $request['name'];
            $object->length = $request['length'];
            $object->width = $request['width'];
            $object->height = $request['height'];
            $object->cost = $request['cost'];
            $object->created_time = array_key_exists('created_time', $request) ? $request['created_time'] : 0;
            $object->install_time = array_key_exists('install_time', $request) ? $request['install_time'] : 0;
            $object->worker_count = array_key_exists('worker_count', $request) ? $request['worker_count'] : 0;
            $object->object_type_id = $request['object_type_id'];
            $object->creator = $request['creator'];
            $object->dead_zone_size = array_key_exists('dead_zone_size', $request) ? $request['dead_zone_size'] : 0;
            $object->style = array_key_exists('style', $request) ? $request['style'] : 'default';
            $object->article = $request['article'];
            $object->left_age = array_key_exists('left_age', $request) ? $request['left_age'] : null;
            $object->right_age = array_key_exists('right_age', $request) ? $request['right_age'] : null;

            if ($object->save()) {
                return json_encode(['result' => ApiHelper::STATUS_SUCCESS, 'id' => $object->id]);
            }
            else {
                return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Saving error, try again']);
            }
        }
        else {
            return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Incorrect query type. Use POST type']);
        }
    }
}