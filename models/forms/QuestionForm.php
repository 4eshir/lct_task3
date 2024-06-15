<?php

namespace app\models\forms;

use yii\base\Model;

class QuestionForm extends Model
{
    public $userId;
    public $territory;
    public $answerAge;
    public $answersSportCoef;
    public $answersRecreationCoef;
    public $answersGameCoef;
    public $answersEducationalCoef;

    public function rules()
    {
        return [
            [['answersSportCoef', 'answersRecreationCoef', 'answersGameCoef', 'answersEducationalCoef', 'userId', 'answerAge', 'territory'], 'required'],
            [['answersSportCoef', 'answersRecreationCoef', 'answersGameCoef', 'answersEducationalCoef', 'userId', 'answerAge', 'territory'], 'integer'],
        ];
    }

    public function save()
    {

    }
}