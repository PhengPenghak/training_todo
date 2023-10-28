<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Todo $model */

$this->title = 'Update Todo: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Todos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="todo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
