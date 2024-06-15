<?php


namespace app\commands;


use app\models\work\AgesWeightChangeableWork;
use app\models\work\AgesWeightWork;
use app\services\WeightChangeService;
use yii\console\Controller;
use yii\helpers\Console;

class ManipulateController extends Controller
{
    private WeightChangeService $weightService;

    public function __construct($id, $module, WeightChangeService $weightService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->weightService = $weightService;
    }

    /**
     * Обнуление весов для территорий
     * @param int $t ID территории, для которой будут обнулены веса
     */
    public function actionResetWeights($t = 1)
    {
        $oldWeights = AgesWeightWork::find()->orderBy(['ages_interval_id' => SORT_ASC])->all();
        $newWeights = AgesWeightChangeableWork::find()->where(['territory_id' => $t])->orderBy(['ages_interval_id' => SORT_ASC])->all();

        for ($i = 0; $i < count($oldWeights); $i++) {
            /** @var AgesWeightChangeableWork[] $newWeights */
            /** @var AgesWeightWork[] $oldWeights */
            $newWeights[$i]->sport_weight = $oldWeights[$i]->sport_weight;
            $newWeights[$i]->game_weight = $oldWeights[$i]->game_weight;
            $newWeights[$i]->recreation_weight = $oldWeights[$i]->recreation_weight;
            $newWeights[$i]->education_weight = $oldWeights[$i]->education_weight;
            $newWeights[$i]->save();
        }
    }

    /**
     * Эмулятор голосования за спортивный коэффициент
     * @param int $t ID территории
     * @param int $w Вес голоса (от 1 до 10)
     * @param int $a Возрастной интервал (от 1 до 7)
     * @param int $c Количество голосов
     * @param int $p Количество голосующих
     */
    public function actionVoteSport($t = 1, $w = 10, $a = 1, $c = 1, $p = 100)
    {
        if ($p < $c) {
            $this->stdout('Количество голосующих больше общего числа людей!', Console::FG_RED);
            return;
        }

        for ($i = 0; $i < $c; $i++) {
            $this->weightService->changeWeight($t, $a, AgesWeightChangeableWork::SPORT_COEF, $p, $w);
        }
    }

    /**
     * Эмулятор голосования за игровой коэффициент
     * @param int $t ID территории
     * @param int $w Вес голоса (от 1 до 10)
     * @param int $a Возрастной интервал (от 1 до 7)
     * @param int $c Количество голосов
     * @param int $p Количество голосующих
     */
    public function actionVoteGame($t = 1, $w = 10, $a = 1, $c = 1, $p = 100)
    {
        if ($p < $c) {
            $this->stdout('Количество голосующих больше общего числа людей!', Console::FG_RED);
            return;
        }

        for ($i = 0; $i < $c; $i++) {
            $this->weightService->changeWeight($t, $a, AgesWeightChangeableWork::GAME_COEF, $p, $w);
        }
    }

    /**
     * Эмулятор голосования за развивающий коэффициент
     * @param int $t ID территории
     * @param int $w Вес голоса (от 1 до 10)
     * @param int $a Возрастной интервал (от 1 до 7)
     * @param int $c Количество голосов
     * @param int $p Количество голосующих
     */
    public function actionVoteEduc($t = 1, $w = 10, $a = 1, $c = 1, $p = 100)
    {
        if ($p < $c) {
            $this->stdout('Количество голосующих больше общего числа людей!', Console::FG_RED);
            return;
        }

        for ($i = 0; $i < $c; $i++) {
            $this->weightService->changeWeight($t, $a, AgesWeightChangeableWork::EDUCATIONAL_COEF, $p, $w);
        }
    }

    /**
     * Эмулятор голосования за рекреационный коэффициент
     * @param int $t ID территории
     * @param int $w Вес голоса (от 1 до 10)
     * @param int $a Возрастной интервал (от 1 до 7)
     * @param int $c Количество голосов
     * @param int $p Количество голосующих
     */
    public function actionVoteRec($t = 1, $w = 10, $a = 1, $c = 1, $p = 100)
    {
        if ($p < $c) {
            $this->stdout('Количество голосующих больше общего числа людей!', Console::FG_RED);
            return;
        }

        for ($i = 0; $i < $c; $i++) {
            $this->weightService->changeWeight($t, $a, AgesWeightChangeableWork::RECREATION_COEF, $p, $w);
        }
    }


    public function actionGenerateArrangement()
    {

    }
}