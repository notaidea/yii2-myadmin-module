<?php

namespace myadmin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use myadmin\models\PermissionForm;

class PermissionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        /* @var $dataProvider ArrayDataProvider */
        $dataProvider = Yii::createObject([
            "class" => ArrayDataProvider::class,
            'allModels' => $auth->getPermissions(),
        ]);

        return $this->render("index", [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $auth = Yii::$app->authManager;
        $model = $auth->getPermission($id);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->render("view", [
            "model" => $model,
        ]);
    }

    public function actionCreate()
    {
        /* @var $model PermissionForm */
        $model = Yii::createObject([
            "class" => PermissionForm::class,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $permission = $auth->createPermission($model->name);
            $permission->description = $model->description;
            $permission->ruleName = $model->ruleName;
            $permission->data = $model->data;
            $auth->add($permission);

            return $this->redirect(["view", "id" => $model->name]);
        }

        return $this->render("create", [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $auth = Yii::$app->authManager;

        /* @var $model PermissionForm */
        $model = Yii::createObject([
            "class" => PermissionForm::class,
        ]);

        if (Yii::$app->request->isGet) {
            $row = $auth->getPermission($id);
            $model->load(ArrayHelper::toArray($row), "");
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $permission = $auth->createPermission($model->name);
            $permission->description = $model->description;
            $permission->ruleName = $model->ruleName;
            $permission->data = $model->data;
            $auth->update($id, $permission);

            return $this->redirect(["view", "id" => $model->name]);
        }

        return $this->render("update", [
            "model" => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($id);
        $auth->remove($permission);

        return $this->redirect(["index"]);
    }
}