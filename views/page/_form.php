<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-12">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-12">
        <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
    </div>
    <div class="col-lg-12">
        <?= $form->field($model, 'preview')->fileInput() ?>
    </div>
    <div class="col-lg-12">
        <?= $form->field($model, 'content')->textarea(['rows' => 12]) ?>
    </div>
    <?php if(Yii::$app->controller->action->id=='update'): ?>
    <div class="col-lg-12">
        <?= $form->field($updateDescription, 'update_description')->textarea(['rows' => 6])->label('Описание изменений') ?>
    </div>
    <?php endif; ?>
    <div class="form-group text-center">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
