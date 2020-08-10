<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "money".
 *
 * @property int $id_money
 * @property string $money_name
 */
class Money extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['money_name'], 'required'],
            [['money_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_money' => Yii::t('app', 'Id Money'),
            'money_name' => Yii::t('app', 'Money Name'),
        ];
    }
}
