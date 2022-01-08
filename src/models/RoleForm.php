<?php

namespace myadmin\models;

use Yii;
use yii\base\Model;

class RoleForm extends Model
{
    public $name;

    public $description;

//    public $rule_name;

//    public $data;

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

//            ["rule_name", "string", ],
//            ["rule_name", "trim", ],

//            ["data", "string", ],
//            ["data", "trim", ],
        ];
    }
}