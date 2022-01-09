<?php

namespace myadmin\models;

use Yii;
use yii\base\Model;

class RoleForm extends Model
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

            ["description", "string", ],
            ["description", "trim", ],
            ["description", "required", ],

            ["data", "string", ],
            ["data", "trim", ],
            ["data", "checkJson", "skipOnEmpty" => true, ],

            ["ruleName", "string", ],
            ["ruleName", "trim", ],
            ["ruleName", "default", "value" => null, ],
            ["ruleName", "checkClass", "skipOnEmpty" => true, 'params' => [
                'auth' => Yii::$app->authManager,
            ]],
        ];
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