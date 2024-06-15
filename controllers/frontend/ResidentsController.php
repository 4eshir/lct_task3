<?php

namespace app\controllers\frontend;

use app\components\arrangement\TerritoryConcept;
use app\models\common\Questionnaire;
use app\models\forms\QuestionDecisionForm;
use app\models\forms\QuestionForm;
use app\models\search\SearchObjectWork;
use app\models\work\ObjectWork;
use app\models\work\QuestionnaireWork;
use app\models\work\UserWork;
use app\services\frontend\ResidentsService;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class ResidentsController extends Controller
{
    // здесь выводим опросник и итоговое голосование

    private ResidentsService $service;

    public function __construct($id, $module, ResidentsService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionStartQuestionnaire()
    {
        Yii::$app->session->set('header-active', 'residents');

        $model = new QuestionForm();

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            Yii::$app->cache->set('questionnaire', serialize($model));
            return $this->redirect(['final-decision']);
        }

        return $this->render('questionnaire', [
            'model' => $model,
        ]);
    }

    public function actionFinalDecision()
    {
        /** @var QuestionForm $questionForm */
        $questionForm = unserialize(Yii::$app->cache->get('questionnaire'));
        $model = new QuestionDecisionForm();
        $model->generateVariants(
            [
                $questionForm->answersRecreationCoef,
                $questionForm->answersSportCoef,
                $questionForm->answersEducationalCoef,
                $questionForm->answersGameCoef
            ],
            $questionForm->territory
        );

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            /** @var QuestionForm $oldAnswers */
            $oldAnswers = unserialize(Yii::$app->cache->get('questionnaire'));

            $questionnaire = new QuestionnaireWork();
            $questionnaire->fill(
                UserWork::getAuthUser()->id,
                $oldAnswers->answerAge,
                $oldAnswers->answersSportCoef,
                $oldAnswers->answersRecreationCoef,
                $oldAnswers->answersGameCoef,
                $oldAnswers->answersEducationalCoef,
                $model->territoires,
                $model->decision,
                $oldAnswers->territory
            );
            $questionnaire->save();

            $genType = '';
            switch ($model->decision) {
                case 1:
                    $genType = TerritoryConcept::TYPE_BASE_WEIGHTS;
                    break;
                case 2:
                    $genType = TerritoryConcept::TYPE_CHANGE_WEIGHTS;
                    break;
                case 3:
                    $genType = TerritoryConcept::TYPE_SELF_VOTES;
                    break;
                default:
                    throw new Exception('Неизвестный тип генерации');
            }

            $this->service->endVote($model->territoires[(int)$model->decision - 1], $genType, $oldAnswers->territory);

            return $this->redirect(['end-questionnaire']);
        }

        return $this->render('final-decision', [
            'model' => $model,
            'territoryId' => $questionForm->territory,
        ]);
    }

    public function actionEndQuestionnaire()
    {
        $text = 'Голосование успешно завершено';

        return $this->render('quest-end', [
            'text' => $text,
        ]);
    }

    public function actionObjectsList()
    {
        Yii::$app->session->set('header-active', 'objects');

        $searchModel = new SearchObjectWork();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('objects-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateTargetObject($targetId)
    {
        $result = '<table class="table table-hover" style="margin-bottom: 40px; margin-top: -10px">';
        $object = ObjectWork::findOne(['id' => $targetId]);
        if (!$object) {
            return '';
        }

        $result .= '<tr><td>Длина (в см)</td><td>'.$object->length.'</td></tr>';
        $result .= '<tr><td>Ширина (в см)</td><td>'.$object->width.'</td></tr>';
        $result .= '<tr><td>Высота (в см)</td><td>'.$object->height.'</td></tr>';
        $result .= '<tr><td>Стоимость</td><td>'.$object->cost.'</td></tr>';
        $result .= '<tr><td>Время изготовления</td><td>'.$object->created_time.' д.</td></tr>';
        $result .= '<tr><td>Время установки</td><td>'.$object->install_time.' д.</td></tr>';
        $result .= '<tr><td>Тип объекта</td><td>'.$object->prettyType.'</td></tr>';
        $result .= '<tr><td>Стиль</td><td>'.$object->style.'</td></tr>';
        $result .= '</table>';

        return $result;
    }
}
