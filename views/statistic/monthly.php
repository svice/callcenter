<?php
/* @var $this yii\web\View */
/* @var $statistic app\models\Statistic[] */
?>
<table class="table">
	<tr>
		<th>Месяц</th><th>Сотрудник</th><th>Звонки</th><th>Бонус</th><th>Зарплата</th>
	</tr>
	<?php foreach ($statistic as $s) {?>
		<tr>
			<td><?=$s->dateMonth?></td>
			<td><?=$s->manager->name?></td>
			<td><?=$s->totalCalls?></td>
			<td><?=$s->bonus ? $s->bonus : 0?></td>
			<td><?=$s->manager->salary + $s->bonus?></td>
			<td><?=$s->manager->getTotalSalary()?></td>
		</tr>
	<?php }?>
</table>

<table class="table">
    <tr>
        <th>Сотрудник</th><th>Выплаты</th>
    </tr>
	<?php foreach (\app\models\Manager::find()->all() as $manager) {?>
        <tr>
            <td><?=$manager->name?></td>
            <td><?=$manager->getTotalSalary()?></td>
        </tr>
	<?php }?>
</table>