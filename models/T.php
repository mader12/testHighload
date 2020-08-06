<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t".
 *
 * @property int $idt
 * @property string $data
 */
class T extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'required'],
            [['data'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idt' => 'Idt',
            'data' => 'Data',
        ];
    }
}
