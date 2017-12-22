<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'parentId')->dropDownList($model->parentCategoriesList()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?/*= $form->field($model, 'meta_json')->textInput() ?>
    <?= $form->field($model, 'lft')->textInput() ?>
    <?= $form->field($model, 'rgt')->textInput() ?>
    <?= $form->field($model, 'depth')->textInput() */?>

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
