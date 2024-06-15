<?php


namespace app\components\arrangement;


use app\models\work\TemplateBlockWork;

class TemplatesManager
{
    public $templateMatrix = [];

    /**
     * Генерирует матрицу с шаблоном расстановки
     * @param int $templateId ID шаблона
     * @param int $targetWidthCell ширина целевой территории (кол-во ячеек)
     * @param int $targetLengthCell длина целевой территории (кол-во ячеек)
     */
    public function generateTemplateMatrix(int $templateId, int $targetWidthCell, int $targetLengthCell)
    {
        $blocks = TemplateBlockWork::find()->where(['arrangement_template_id' => $templateId])->all();
        $this->templateMatrix = array_fill(0, $targetWidthCell, array_fill(0, $targetLengthCell, 0));

        foreach ($blocks as $block) {
            /** @var TemplateBlockWork $block */
            $topR = round(($targetWidthCell * $block->top) / 100);
            $leftR = round(($targetLengthCell * $block->left) / 100);
            $widthR = round(($targetWidthCell * $block->width) / 100);
            $lengthR = round(($targetLengthCell * $block->length) / 100);

            for ($i = $topR; $i < $topR + $widthR; $i++) {
                for ($j = $leftR; $j < $leftR + $lengthR; $j++) {
                    $this->templateMatrix[$i][$j] = $block->object_type_id ? : -1;
                }
            }
        }
    }

    public function getTemplateMatrix()
    {
        return $this->templateMatrix;
    }

    public function showDebugTemplateMatrix($stream)
    {
        for ($i = 0; $i < count($this->templateMatrix); $i++) {
            for ($j = 0; $j < count($this->templateMatrix[$i]); $j++) {
                fwrite($stream, $this->templateMatrix[$i][$j].' ');
            }
            fwrite($stream, "\n");
        }

        fwrite($stream, "\n");
    }
}