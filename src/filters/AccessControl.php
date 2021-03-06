<?php

namespace myadmin\filters;

use Yii;
use yii\base\Module;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;

/**
 * Access Control Filter (ACF) is a simple authorization method that is best used by applications that only need some simple access control.
 * As its name indicates, ACF is an action filter that can be attached to a controller or a module as a behavior.
 * ACF will check a set of access rules to make sure the current user can access the requested action.
 *
 * To use AccessControl, declare it in the application config as behavior.
 * For example.
 *
 * ```
 * 'as access' => [
 *     'class' => 'backend\modules\myadmin\filters\AccessControl',
 *
 *     //admin的id，拥有所有权限
 *     "adminIds" => [
 *         1,
 *     ],
 *
 *     //不需要认证的路由
 *     //不带"/"开头，暂时不支持通配符
 *     'allowActions' => [
 *         'debug/default/index',
 *         'site/login',
 *         'site/error',
 *      ]
 * ]
 * ```
 *
 * @property User $user
 *
 */
class AccessControl extends \yii\base\ActionFilter
{
    /**
     * @var User User for check access.
     */
    private $_user = 'user';

    /**
     * @var array List of action that not need to check access.
     */
    public $allowActions = [];

    /**
     * @var array List of admin that not need to check access.
     */
    public $adminIds = [];

    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }
        return $this->_user;
    }

    /**
     * Set user
     * @param User|string $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        //当前的URL，含module/controller/action
        $actionId = $action->getUniqueId();

        $user = $this->getUser();

        if (in_array($user->id, $this->adminIds)) {
            return true;
        }

        //if (Helper::checkRoute('/' . $actionId, Yii::$app->getRequest()->get(), $user)) {
        if (Yii::$app->user->can('/' . $actionId)) {
            return true;
        }

        $this->denyAccess($user);
    }

    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param  User $user the current user
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * 这是父类调用的方法
     */
    protected function isActive($action)
    {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }

        $user = $this->getUser();
        if($user->getIsGuest()) {
            $loginUrl = null;
            if(is_array($user->loginUrl) && isset($user->loginUrl[0])){
                $loginUrl = $user->loginUrl[0];
            }else if(is_string($user->loginUrl)){
                $loginUrl = $user->loginUrl;
            }
            if(!is_null($loginUrl) && trim($loginUrl,'/') === $uniqueId)
            {
                return false;
            }
        }

        if ($this->owner instanceof Module) {
            // convert action uniqueId into an ID relative to the module
            $mid = $this->owner->getUniqueId();
            $id = $uniqueId;
            if ($mid !== '' && strpos($id, $mid . '/') === 0) {
                $id = substr($id, strlen($mid) + 1);
            }
        } else {
            $id = $action->id;
        }

        foreach ($this->allowActions as $route) {
            if (substr($route, -1) === '*') {
                $route = rtrim($route, "*");
                if ($route === '' || strpos($id, $route) === 0) {
                    return false;
                }
            } else {
                if ($id === $route) {
                    return false;
                }
            }
        }

        if ($action->controller->hasMethod('allowAction') && in_array($action->id, $action->controller->allowAction())) {
            return false;
        }

        return true;
    }
}
