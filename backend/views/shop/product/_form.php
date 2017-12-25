<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\forms\manage\shop\ProductForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php //$form = ActiveForm::begin(); ?>

    <?php
    $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'options' => [
                'enctype' => 'multipart/form-data',
        ],
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?//= $model->getImageFileUrl('imageUpload') ?>

    <?= $form->field($model, 'category_id')->dropDownList($model->CategoriesList()) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'available')->textInput() ?>

    <?/*
    <?=$form->field($model, 'category_id')->textInput() ?>

    <?=$form->field($model, 'comment_count')->textInput() ?>

    <?=$form->field($model, 'created_at')->textInput() ?>

    <?=$form->field($model, 'updated_at')->textInput() ?>
    */ ?>


    <div class="form-group">
        <h2>Мета теги</h2>
        <?= $form->field($model->meta, 'title')->textInput() ?>
        <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
        <?= $form->field($model->meta, 'robots')->checkboxList(['nofollow' => 'nofollow', 'noindex' => 'noindex']) ?>
    </div>

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
