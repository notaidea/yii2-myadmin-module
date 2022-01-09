<?php

namespace myadmin\models;

use Yii;
use yii\base\Model;

class RuleForm extends Model
{
    public $name;

    //public $className;

    public function rules()
    {
        return [
            ["name", "string", ],
            ["name", "trim", ],
            ["name", "required", ],
            ["name", "checkClass", ],

//            ["className", "string", ],
//            ["className", "trim", ],
//            ["className", "required", ],
//            ["className", "checkClass", ],
        ];
    }

    public function checkClass($fieldName, $params, $validator)
    {
        if (!class_exists($this->name)) {
            $this->addError($fieldName, "Rule Class does not exist.");
            return;
        }

        if (!is_subclass_of($this->name,'yii\rbac\Rule')) {
            $this->addError($fieldName, 'Rule Class must extend yii\rbac\Rule.');
            return;
        }
    }
}