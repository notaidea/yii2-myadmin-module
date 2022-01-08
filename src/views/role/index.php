<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'Role';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        //更多属性详见：yii\grid\GridView.php
        'dataProvider' => $dataProvider,

        //显示字段
        'columns' => [
            //============================== 行号 ==============================
            ['class' => 'yii\grid\SerialColumn'],

            //============================== 直接显示字段 ==============================
            'name',
            'description',

            //============================== 格式化字段 ==============================
            //'created_at',
            [
                'attribute' => 'createdAt',
                'value' => function($model, $key, $index, $obj) {
                    return date('Y-m-d H:i:s', $model->createdAt);
                }
            ],

            //'updated_at',
            [
                'attribute' => 'updatedAt',
                'value' => function($model, $key, $index, $obj) {
                    return date('Y-m-d H:i:s', $model->updatedAt);
                }
            ],

            //============================== 操作列 ==============================
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>