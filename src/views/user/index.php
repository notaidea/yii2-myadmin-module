<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        //更多属性详见：yii\grid\GridView.php
        'dataProvider' => $dataProvider,

        'layout' => "{items}\n{summary}\n{pager}",
        //搜索
        //'filterModel' => $searchModel,

        //显示字段
        'columns' => [
            //============================== 行号 ==============================
            ['class' => 'yii\grid\SerialColumn'],

            //============================== 直接显示字段 ==============================
            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'email:email',

            //============================== 格式化字段 ==============================
            //更多配置详见：yii\grid\DataColumn
            //'status',
            [
                'attribute' => 'status',
                'value' => function($model, $key, $index, $obj) {
                    if ($model->status == 10) {
                        return '已认证';
                    } else {
                        return '待认证';
                    }
                }
            ],

            //'created_at',
            [
                'attribute' => 'created_at',
                'value' => function($model, $key, $index, $obj) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
            ],

            //'updated_at',
            [
                'attribute' => 'updated_at',
                'value' => function($model, $key, $index, $obj) {
                    return date('Y-m-d H:i:s', $model->updated_at);
                }
            ],

            //============================== assign操作列 ==============================
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{assign}',
                'buttons' => [
                    'assign' => function($url, $model, $index) {
                        return Html::a("分配权限", $url);
                    }
                ]
            ],

            //============================== 操作列 ==============================
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
