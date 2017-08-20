<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "manager".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $second_name
 * @property integer $salary
 *
 * @property Statistic[] $statistics
 * @property Statistic[] $monthlyCalls
 */
class Manager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manager';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salary'], 'integer'],
            [['first_name', 'second_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'second_name' => 'Second Name',
            'salary' => 'Salary',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatistics()
    {
        return $this->hasMany(Statistic::className(), ['manager_id' => 'id']);
    }

	public function getName() {
		return $this->first_name.' '.$this->second_name;
	}

    public static function getDropDownSelect() {
    	$result = self::find()->asArray()->all();
    	return ArrayHelper::map($result, 'id', 'second_name');
	}

	public function getMonthlyCalls() {
		return Statistic::find()->select(['DATE_FORMAT(date, "%Y-%m") as dateMonth', 'manager_id', 'SUM(calls_count) as totalCalls'])
			->groupBy(['dateMonth'])
			->where(['manager_id' => $this->id])
			->all();
	}

	public function getMonthlyBonus() {
    	$result = [];
		foreach ($this->monthlyCalls as $month) {
			$month->bonus = Bonus::find()->where(['<=', 'bonus_step', $month->totalCalls])
				->orderBy('bonus_step DESC')->one();
			if (!is_null($month->bonus)) {
				$month->bonus = $month->bonus->bonus_amount;
			}
			$result[] = $month;
		}
		return $result;
	}

	public function getTotalSalary() {
    	$totalPayed = 0;
		foreach ($this->getMonthlyBonus() as $month) {
			$totalPayed = $totalPayed + $month->bonus + $this->salary;
		}
		return $totalPayed;
	}
}
