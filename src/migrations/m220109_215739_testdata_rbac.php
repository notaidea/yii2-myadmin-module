<?php

use yii\db\Migration;
use yii\rbac\DbManager;
use yii\base\InvalidConfigException;

/**
 * Class m220109_215739_testdata_rbac
 */
class m220109_215739_testdata_rbac extends Migration
{
    protected function getAuthManager()
    {
        /** @var $authManager \yii\rbac\DbManager */
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $authManager = $this->getAuthManager();

        //==================================================
        //create role
        $role1 = $authManager->createRole("经理");
        $role1->description = "经理";
        $authManager->add($role1);

        $role2 = $authManager->createRole("编辑");
        $role2->description = "编辑";
        $authManager->add($role2);

        //==================================================
        //create permission
        $permission1 = $authManager->createPermission("/myadmin/articles/index");
        $permission1->description = "/myadmin/articles/index";
        $authManager->add($permission1);

        $permission2 = $authManager->createPermission("/myadmin/articles/view");
        $permission2->description = "/myadmin/articles/view";
        $authManager->add($permission2);

        $permission3 = $authManager->createPermission("/myadmin/articles/create");
        $permission3->description = "/myadmin/articles/create";
        $authManager->add($permission3);

        $permission4 = $authManager->createPermission("/myadmin/articles/delete");
        $permission4->description = "/myadmin/articles/delete?id={x}";
        $authManager->add($permission4);

        //==================================================
        //binding role and permission
        $authManager->addChild($role2, $permission1);
        $authManager->addChild($role2, $permission3);

        //==================================================
        //create rule
        $rule1 = new \myadmin\ARule();
        $rule1->name = get_class($rule1);

        $rule2 = new \myadmin\BRule();
        $rule2->name = get_class($rule2);

        $authManager->add($rule1);
        $authManager->add($rule2);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220109_215739_testdata_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220109_215739_testdata_rbac cannot be reverted.\n";

        return false;
    }
    */
}
