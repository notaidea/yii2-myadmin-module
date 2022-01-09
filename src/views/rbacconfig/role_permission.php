<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles array */
/* @var $permissions array */
/* @var $selectPermissions array */
?>

<div class="role_permission-form">

    <?php $form = ActiveForm::begin(); ?>
        <?php //$form->field($model, 'description')->textInput() ?>
    
        <?php foreach ($roles as $k => $v): ?>
            <fieldset>
                <legend>
                    <?php echo Html::checkbox($v->name); ?>
                    <?php echo $v->name; ?>
                </legend>

                <?php foreach ($permissions as $k2 => $v2): ?>
                    <?php
                        $checked = false;
                        if (isset($selectPermissions[$v->name]) && in_array($v2->name, $selectPermissions[$v->name])) {
                            $checked = true;
                        }
                    ?>
                    <?php echo Html::checkbox("{$v->name}[]", $checked, ["value" => $v2->name, "class" => '']); ?>
                    <?php echo $v2->name; ?>
                <?php endforeach; ?>
            </fieldset>
            <br>
        <?php endforeach; ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
