<?php

namespace myadmin\models;

use Yii;
use yii\base\Model;

class PermissionForm extends Model
{
    public $name;

    public $description;

    public $ruleName;

    public $data;

    public function rules()
    {
        return [
            ["name", "string", ],
            ["name", "trim", ],
            ["name", "required", ],
            //["name", "unique", ],
            ["name", "checkName", ],

            ["description", "string", ],
            ["description", "trim", ],
            ["description", "required", ],

            ["ruleName", "string", ],
            ["ruleName", "trim", ],
            ["ruleName", "default", "value" => null, ],
            ["ruleName", "checkClass", "skipOnEmpty" => true, 'params' => [
                'auth' => Yii::$app->authManager,
            ]],

            ["data", "string", ],
            ["data", "trim", ],
            ["data", "checkJson", "skipOnEmpty" => true, ],
        ];
    }

    public function checkName($fieldName, $params, $validator, $value)
    {
        if ($value[0] != "/") {
            $this->addError($fieldName, "permission must starts with the '/'");
            return;
        }
    }

    public function checkJson($fieldName, $params, $validator, $value)
    {
        if ($value == "" || $value == null) {
            return;
        }

        $isJson = json_decode($value);
        if ($isJson === null) {
            $this->addError($fieldName, "必须输入json格式的数据");
            return;
        }
    }

    public function checkClass($fieldName, $params, $validator, $value)
    {
        $rule = $params["auth"]->getRule($value);

        if (!$rule) {
            $this->addError($fieldName, "Rule Class does not exist.Pleas add rule first.");
            return;
        }
    }
}