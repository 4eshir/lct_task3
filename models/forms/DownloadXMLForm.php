<?php


namespace app\models\forms;


use app\models\work\ObjectTypeWork;
use app\models\work\ObjectWork;
use yii\base\Model;

class DownloadXMLForm extends Model
{
    public $xmlFile;

    public function rules()
    {
        return [
            [['xmlFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xml'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'xmlFile' => 'XML-файл с МАФ',
        ];
    }

    public function importXml()
    {
        $xml = simplexml_load_file($this->xmlFile->tempName);

        foreach ($xml->objects_list->object as $objectData) {
            $object = new ObjectWork();

            $object->id = (int) $objectData['id'];
            $object->name = (string) $objectData['name'];
            $object->length = (int) $objectData['length'];
            $object->width = (int) $objectData['width'];
            $object->height = (int) $objectData['height'];
            $object->cost = (int) $objectData['cost'];
            $object->created_time = (int) $objectData['created_time'];
            $object->install_time = (int) $objectData['install_time'];
            $object->worker_count = (int) $objectData['worker_count'];
            $object->object_type_id = ObjectTypeWork::find()->where(['name' => (string) $objectData['object_type']])->one()->id;
            $object->creator = (string) $objectData['creator'];
            $object->dead_zone_size = (int) $objectData['dead_zone_size'];
            $object->style = (string) $objectData['style'];
            $object->article = (string) $objectData['article'];
            $object->left_age = (string) $objectData['left_age'];
            $object->right_age = (string) $objectData['right_age'];

            $object->save();
        }

        return true;
    }
}