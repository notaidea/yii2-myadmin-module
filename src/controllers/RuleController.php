<?php

namespace myadmin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use \myadmin\models\RuleForm;

class RuleController extends Controller
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
            'allModels' => $auth->getRules(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $auth = Yii::$app->authManager;
        $model = $auth->getRule($id);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        /* @var $model RuleForm */
        $model = Yii::createObject([
            'class' => RuleForm::class,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $rule = Yii::createObject($model->name);
            $rule->name = $model->name;
            $res = $auth->add($rule);

            return $this->redirect(['view', 'id' => $rule->name]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $auth = Yii::$app->authManager;

        /* @var $model RuleForm */
        $model = Yii::createObject([
            "class" => RuleForm::class,
        ]);

        if (Yii::$app->request->isGet) {
            $row = $auth->getRule($id);
            $model->load(ArrayHelper::toArray($row), "");
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;

            //更新，先创建，再update
            $rule = Yii::createObject($model->name);
            $rule->name = $model->name;

            $res = $auth->update($id, $rule);

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render("update", [
            "model" => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $rule = $auth->getRule($id);
        $auth->remove($rule);

        return $this->redirect(['index']);
    }
}