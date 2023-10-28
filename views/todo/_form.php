<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Todo $model */
/** @var yii\widgets\ActiveForm $form */
?>



<div class="todo-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Todo.....']) ?>

    <div class="form-group p-2">
        <?= Html::submitButton('Save', ['class' => 'btn btn-dark ',]) ?>
        <!-- <? Html::a('Cancel', ['todo/cancel', 'id' => $model->id], ['class' => 'btn btn-warning ']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>