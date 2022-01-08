<?php

namespace myadmin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use \myadmin\models\RoleForm;

class RoleController extends Controller
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
            'class' => ArrayDataProvider::class,
            'allModels' => $auth->getRoles(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $auth = Yii::$app->authManager;
        $model = $auth->getRole($id);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        /* @var $model RoleForm */
        $model = Yii::createObject([
            'class' => RoleForm::class,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $role = $auth->createRole($model->name);
            $role->description = $model->description;
            $res = $auth->add($role);

            return $this->redirect(['view', 'id' => $role->name]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $auth = Yii::$app->authManager;

        /* @var $model RoleForm */
        $model = Yii::createObject([
            "class" => RoleForm::class,
        ]);

        if (Yii::$app->request->isGet) {
            $row = $auth->getRole($id);
            $model->load(ArrayHelper::toArray($row), "");
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;

            //更新，先创建，再update
            $role = $auth->createRole($model->name);
            $role->description = $model->description;

            $res = $auth->update($id, $role);

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render("update", [
            "model" => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($id);
        $auth->remove($role);

        return $this->redirect(['index']);
    }
}