<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AssessmentForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assessment-form-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'enrolled_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tuition_id')->textInput() ?>

    <?= $form->field($model, 'has_sibling_discount')->textInput() ?>

    <?= $form->field($model, 'has_book_discount')->textInput() ?>

    <?= $form->field($model, 'has_honor_discount')->textInput() ?>

    <?= $form->field($model, 'sibling_discount')->textInput() ?>

    <?= $form->field($model, 'book_discount')->textInput() ?>

    <?= $form->field($model, 'honor_discount')->textInput() ?>

    <?= $form->field($model, 'total_assessed')->textInput() ?>

    <?= $form->field($model, 'balance')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>