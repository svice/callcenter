<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Statistic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statistic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
		'language' => 'ru',
		'dateFormat' => 'yyyy-MM-dd',
		'clientOptions' => ['defaultDate' => '2015-01-01'],
		'options' => ['class' => 'form-control']
	]) ?>

    <?= $form->field($model, 'manager_id')->dropDownList(\app\models\Manager::getDropDownSelect()) ?>

    <?= $form->field($model, 'calls_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
