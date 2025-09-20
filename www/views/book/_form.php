<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\request\BookCreateRequest $request
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($request, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($request, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($request, 'isbn')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
