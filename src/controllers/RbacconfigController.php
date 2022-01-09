<?php

namespace myadmin\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

class RbacconfigController extends Controller
{
    //分配权限给角色
    public function actionRolepermission()
    {
        $auth = Yii::$app->authManager;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            foreach ($post as $k => $v) {
                $role = $auth->getRole($k);
                if (!$role) {
                    continue;
                }

                //移除原有的权限
                $allPermissions = $auth->getPermissionsByRole($k);
                foreach ($allPermissions as $k2 => $v2) {
                    $auth->removeChild($role, $v2);
                }

                //写入新的权限
                foreach ($v as $k3 => $v3) {
                    $permission = $auth->createPermission($v3);

                    $auth->addChild($role, $permission);
                }
            }
        }

        //所有角色
        $roles = $auth->getRoles();

        //所有权限
        $permissions = $auth->getPermissions();

        //角色选中的权限
        $selectPermissions = [];
        foreach ($roles as $k => $v) {
            $selectPermissions[$v->name] = ArrayHelper::getColumn(
                ArrayHelper::toArray($auth->getPermissionsByRole($v->name)),
                "name",
                false
            );
        }

        return $this->render("role_permission", [
            "roles" => $roles,
            "permissions" => $permissions,
            "selectPermissions" => $selectPermissions,
        ]);
    }
}