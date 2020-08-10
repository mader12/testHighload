<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "money_count".
 *
 * @property int $id_mc
 * @property string $count
 * @property string $data
 * @property string $id_money
 */
class MoneyCount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money_count';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count', 'id_money'], 'required'],
            [['data'], 'safe'],
            [['count', 'id_money'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mc' => Yii::t('app', 'Id Mc'),
            'count' => Yii::t('app', 'Count'),
            'data' => Yii::t('app', 'Data'),
            'id_money' => Yii::t('app', 'Id Money'),
        ];
    }
}
