<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statistic".
 *
 * @property integer $id
 * @property string $date
 * @property integer $manager_id
 * @property integer $dateMonth
 * @property integer $totalCalls
 * @property integer $bonus
 *
 * @property Manager $manager
 */
class Statistic extends \yii\db\ActiveRecord
{
	public $dateMonth;
	public $totalCalls;
	public $bonus;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['manager_id', 'calls_count'], 'integer'],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'manager_id' => 'Manager ID',
            'calls_count' => 'Calls Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(), ['id' => 'manager_id']);
    }

    public static function getMonthlyCalls() {
    	return self::find()->select(['DATE_FORMAT(date, "%Y-%m") as dateMonth', 'manager_id', 'SUM(calls_count) as totalCalls'])
			->groupBy(['dateMonth', 'manager_id'])
			->all();
	}

	public static function getMonthlyBonus() {
		$result = [];
		foreach (self::getMonthlyCalls() as $key => $month) {
			$month->bonus = Bonus::find()
				->where(['<=', 'bonus_step', $month->totalCalls])
				->orderBy('bonus_step DESC')
				->one();
			if (!is_null($month->bonus)) {
				$month->bonus = $month->bonus->bonus_amount;
			}
			$result[] = $month;
		}
		return $result;
	}
}
