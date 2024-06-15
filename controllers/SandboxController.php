<?php

namespace app\controllers;

use app\facades\TerritoryFacade;
use app\helpers\ApiHelper;
use app\models\common\ObjectT;
use app\models\common\User;
use app\models\forms\sandbox\GenerateArrangementForm;
use app\models\forms\sandbox\GetObjectsForm;
use app\models\forms\sandbox\GetRealWeightsForm;
use app\models\forms\sandbox\LoadObjectForm;
use app\models\forms\sandbox\LoadTerritoryForm;
use app\models\work\AgesWeightChangeableWork;
use app\models\work\ObjectWork;
use app\models\work\TerritoryWork;
use app\services\ApiService;
use Yii;
use yii\base\BaseObject;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SandboxController extends Controller
{
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionGetObjects()
    {
        $model = new GetObjectsForm();

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $query = ObjectWork::find();

            if ($model->type !== "") {
                $query->andWhere(['object_type_id' => $model->type]);
            }

            if ($model->minCost !== "") {
                $query->andWhere(['>=', 'cost', $model->minCost]);
            }

            if ($model->maxCost !== "") {
                $query->andWhere(['<=', 'cost', $model->maxCost]);
            }

            if ($model->style !== "") {
                $query->andWhere(['style' => $model->style]);
            }

            $data['result'] = ApiHelper::STATUS_SUCCESS;
            $data['data'] = [];
            foreach ($query->all() as $item) {
                $data['data'][] = $item->attributes;
            }

            return json_encode($data);
        }

        return $this->render('get-objects', [
            'model' => $model,
        ]);
    }

    /**
     * Возвращает список дворовых территорий
     * @return array|false|string
     */
    public function actionGetTerritories()
    {
        if (Yii::$app->request->post()) {
            $query = TerritoryWork::find();

            $data['result'] = ApiHelper::STATUS_SUCCESS;
            $data['data'] = [];
            foreach ($query->all() as $item) {
                $data['data'][] = $item->attributes;
            }

            return json_encode($data);
        }

        return $this->render('get-territories');
    }

    public function actionGetRealWeights()
    {
        $model = new GetRealWeightsForm();
        $selectedAttr = ['id', 'self_weight', 'recreation_weight', 'sport_weight', 'education_weight', 'game_weight', 'ages_interval_id', 'territory_id'];

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $query = AgesWeightChangeableWork::find();

            if ($model->weightsType !== "") {
                switch ($model->weightsType) {
                    case AgesWeightChangeableWork::RECREATION_COEF:
                        $query = $query->select('id, self_weight, recreation_weight, ages_interval_id, territory_id');
                        $selectedAttr = ['id', 'self_weight', 'recreation_weight', 'ages_interval_id', 'territory_id'];
                        break;
                    case AgesWeightChangeableWork::SPORT_COEF:
                        $query = $query->select('id, self_weight, sport_weight, ages_interval_id, territory_id');
                        $selectedAttr = ['id', 'self_weight', 'sport_weight', 'ages_interval_id', 'territory_id'];
                        break;
                    case AgesWeightChangeableWork::EDUCATIONAL_COEF:
                        $query = $query->select('id, self_weight, education_weight, ages_interval_id, territory_id');
                        $selectedAttr = ['id', 'self_weight', 'education_weight', 'ages_interval_id', 'territory_id'];
                        break;
                    case AgesWeightChangeableWork::GAME_COEF:
                        $query = $query->select('id, self_weight, game_weight, ages_interval_id, territory_id');
                        $selectedAttr = ['id', 'self_weight', 'game_weight', 'ages_interval_id', 'territory_id'];
                        break;
                    default:
                        throw new Exception('Неизвестный тип веса');
                }
            }

            $query = $query->where(['territory_id' => $model->tId]);

            if ($model->agesInterval !== "") {
                $query = $query->andWhere(['ages_interval_id' => $model->agesInterval]);
            }

            $data['result'] = ApiHelper::STATUS_SUCCESS;
            $data['data'] = [];
            foreach ($query->select($selectedAttr)->all() as $item) {
                $attributes = [];

                // Получаем только указанные в SELECT запросе атрибуты
                foreach ($selectedAttr as $attribute) {
                    $attributes[$attribute] = $item->$attribute;
                }

                $data['data'][] = $attributes;
            }

            return json_encode($data);
        }

        return $this->render('get-real-weights', [
            'model' => $model,
        ]);
    }

    public function actionGenerateArrangement()
    {
        $model = new GenerateArrangementForm();

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $facade = Yii::createObject(TerritoryFacade::class);
            $facade->generateTerritoryArrangement(
                $model->genType,
                $model->tId,
                $model->addGenType == '' ? TerritoryFacade::OPTIONS_DEFAULT : $model->addGenType,
                $model->params == '' ? [] : $model->params);

            $data['result'] = ApiHelper::STATUS_SUCCESS;
            $data['data'] = $facade->getRawMatrix();

            return json_encode($data);
        }

        return $this->render('generate-arrangement', [
            'model' => $model,
        ]);
    }

    public function actionLoadTerritory()
    {
        $model = new LoadTerritoryForm();

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $territory = new TerritoryWork();
            $territory->width = $model->width;
            $territory->length = $model->length;
            $territory->name = $model->name;
            $territory->address = $model->address;
            $territory->latitude = $model->latitude;
            $territory->longitude = $model->longitude;
            if ($territory->save()) {
                return json_encode(['result' => ApiHelper::STATUS_SUCCESS, 'id' => $territory->id]);
            }
            else {
                return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Saving error, try again']);
            }
        }

        return $this->render('load-territory', [
            'model' => $model,
        ]);
    }

    public function actionLoadObject()
    {
        $model = new LoadObjectForm();

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $object = new ObjectWork();
            $object->name = $model->name;
            $object->length = $model->length;
            $object->width = $model->width;
            $object->height = $model->height;
            $object->cost = $model->cost;
            $object->created_time = $model->created_time !== '' ? $model->created_time : null;
            $object->install_time = $model->install_time !== '' ? $model->install_time : null;
            $object->worker_count = $model->worker_count !== '' ? $model->worker_count : null;
            $object->object_type_id = $model->object_type_id;
            $object->creator = $model->creator;
            $object->dead_zone_size = $model->dead_zone_size !== '' ? $model->dead_zone_size : null;
            $object->style = $model->style !== '' ? $model->style : null;
            $object->article = $model->article;
            $object->left_age = $model->left_age !== '' ? $model->left_age : null;
            $object->right_age = $model->right_age !== '' ? $model->right_age : null;

            if ($object->save()) {
                return json_encode(['result' => ApiHelper::STATUS_SUCCESS, 'id' => $object->id]);
            }
            else {
                return json_encode(['result' => ApiHelper::STATUS_ERROR, 'error_message' => 'Saving error, try again']);
            }
        }

        return $this->render('load-object', [
            'model' => $model,
        ]);
    }
}