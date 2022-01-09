<?php

namespace myadmin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class ArticlesController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

//        $behaviors["access"] = [
//            "class" => AccessControl::class,
//            "rules" => [
//                [
//                    //==================================================
//                    'allow' => true,
//
//                    //==================================================
//                    //不指定actions的话，就对所有action生效
//                    //否则只对actions中的生效
//                    //'actions' => ['index', 'create'],
//
//                    //==================================================
//                    //roles和permissions二选一即可（优先使用permissions）
//
//                    //只有指定的能角色访问指定的actions
//                    //?未登录的；@已登录的
//                    'roles' => ['编辑'],
//
//                    //传入到roles的参数
//                    /*
//                    'roleParams' => function($rule) {
//                        return ['post' => Post::findOne(Yii::$app->request->get('id'))];
//                    },
//                    */
//
//                    //权限
////                    'permissions' => [
////                        '/myadmin/articles/index',
////                    ],
//                ],
//            ],
//        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionCreate()
    {
        return $this->render("create");
    }

    public function actionView($id)
    {
        return $this->render("view", [
            "id" => $id,
        ]);
    }

    public function actionDelete($id)
    {
        return $this->render("delete", [
            "id" => $id,
        ]);
    }
}