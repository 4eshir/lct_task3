<?php

namespace app\controllers\frontend;

use app\components\arrangement\TemplatesManager;
use app\models\common\ArrangementTemplate;
use app\models\forms\AnalyticModel;
use app\models\forms\ChooseTerritoryForm;
use app\models\forms\ConstructorTerritoryForm;
use app\models\work\ArrangementTemplateWork;
use app\models\work\TemplateBlockWork;
use app\services\frontend\AdministrationService;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class AdministrationController extends Controller
{
    // здесь выводим только конструктор расстановки, остальное - в backend

    private AdministrationService $service;
    private TemplatesManager $template;

    public function __construct($id, $module, AdministrationService $service, TemplatesManager $template, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->template = $template;
    }

    public function actionIndex()
    {
        Yii::$app->session->set('header-active', 'administration');

        return $this->render('index');
    }

    public function actionChooseConstructor()
    {
        $model = new ChooseTerritoryForm();

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            return $this->redirect(['constructor', 'tId' => $model->territoryId]);
        }

        return $this->render('choose-constructor', [
            'model' => $model,
        ]);
    }

    public function actionTemplates()
    {
        $templatesId = ArrayHelper::getColumn(ArrangementTemplateWork::find()->all(), 'id');
        $matrices = [];
        $names = [];
        $descs = [];

        foreach ($templatesId as $templateId) {
            $this->template->generateTemplateMatrix($templateId, 20, 20);
            $matrices[] = $this->template->getTemplateMatrix();
            $names[] = ArrangementTemplateWork::find()->where(['id' => $templateId])->one()->name;
            $descs[] = ArrangementTemplateWork::find()->where(['id' => $templateId])->one()->description;
        }

        return $this->render('templates', [
            'model' => $matrices,
            'names' => $names,
            'descs' => $descs,
        ]);
    }

    public function actionConstructor($tId)
    {
        $model = new ConstructorTerritoryForm($tId);

        return $this->render('constructor', [
            'model' => $model
        ]);
    }
}
