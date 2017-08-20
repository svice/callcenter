<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bonus".
 *
 * @property integer $id
 * @property integer $bonus_step
 * @property string $category
 * @property string $bonus_amount
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bonus_step'], 'integer'],
            [['category', 'bonus_amount'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bonus_step' => 'Bonus Step',
            'category' => 'Category',
            'bonus_amount' => 'Bonus Amount',
        ];
    }
}
