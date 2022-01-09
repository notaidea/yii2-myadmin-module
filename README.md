#Installation
composer require notaidea/yii2-myadmin-module

or

backend/config/main.php - aliases

console/config/main.php - aliases

    //@backend/extensions/myadmin/src/
    
    '@myadmin' => "path_to_the_package",

#config
backend/config/main.php - modules

    'myadmin' => [
    
        'class' => \myadmin\Module::class,
        
    ],

common/config/main.php - components

    'authManager' => [
        
        'class' => 'yii\rbac\DbManager',
        
    ]

#Migrate
php yii migrate --migrationPath=@yii/rbac/migrations

##test data migration(optional)

php yii migrate --migrationPath=@myadmin/migrations

#URL
## backend - URL
/myadmin/user/index

/myadmin/role/index

/myadmin/permission/index

/myadmin/rbacconfig/rolepermission

/myadmin/rule/index

##test data - URL
/myadmin/articles/index

/myadmin/articles/create

/myadmin/articles/view?id={x}

/myadmin/articles/delete?id={x}

#USAGE
1. add some roles and permissions
2. go to the /myadmin/user/index，assign role(s) to the user.
