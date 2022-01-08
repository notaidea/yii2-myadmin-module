<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search layui-row">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',

        //form的css
        'options' => [
            'class' => 'layui-form',
        ],

        //input标签外层div的css
        'fieldConfig'=>[
            'options'=>['class'=>'layui-form-item'],
        ],
    ]); ?>

    <!-- 显示的字段 -->
    <div class="layui-col-xs3">
        <?php
            echo $form->field($model, 'username')
                //input标签的css属性
                ->input('text', ['class' => 'layui-input', ]);
        ?>
    </div>
    <div class="form-group layui-clear">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
