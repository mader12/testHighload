<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "money".
 *
 * @property int $id_money
 * @property string $money_Name
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
            [['money_Name', 'money_CharCode', 'money_attr', 'money_NumCode', 'money_Nominal'], 'required'],
            [['money_Name', 'money_CharCode', 'money_attr', 'money_NumCode', 'money_Nominal'], 'string', 'max' => 45]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_money' => Yii::t('app', 'Id Money'),
            'money_Name' => Yii::t('app', 'Money Name'),
            'money_CharCode' => Yii::t('app', 'CharCode'),
            'money_Nominal' => Yii::t('app', 'Nominal'),
            'money_attr' => Yii::t('app', 'Attr'),
        ];
    }
}
