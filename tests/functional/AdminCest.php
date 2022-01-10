<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

class AdminCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('Username', 'test1');
        $I->fillField('Password', '12345678');
        $I->click('login-button');
    }

    // tests
    public function successTest(FunctionalTester $I)
    {
        $I->amOnPage('/myadmin/user/index');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/myadmin/role/index');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/myadmin/permission/index');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/myadmin/rule/index');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/myadmin/articles/index');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/myadmin/articles/create');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/myadmin/articles/view?id=20');
        $I->canSeeResponseCodeIs(200);

        $I->amOnPage('/myadmin/articles/delete?id=10');
        $I->canSeeResponseCodeIs(200);
    }
}
