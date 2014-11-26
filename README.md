CMS user module for Yii 2
========================

Docs
-----
- [Documentation](http://yii2-user.readthedocs.org/en/latest/).


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require infoweb-internet-solutions/yii2-cms-user "*"
```

or add

```
"infoweb-internet-solutions/yii2-user": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply modify your backend configuration as follows:

```php
return [
    'components' => [
        ...
        // Replace default user component:
        'user' => [
            'identityClass' => 'infoweb\user\models\User',
            'enableAutoLogin' => true,
        ],
        // Override views
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@infoweb/user/views'
                ]
            ]
        ],
    ],
    ...
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['infoweb', 'admin'],
            'webUserClass' => 'infoweb\user\models\WebUser',
            'components' => [
                'manager' => [
                    'userClass' => 'infoweb\user\models\User',
                    'userSearchClass' => 'infoweb\user\models\UserSearch',
                    'profileClass' => 'infoweb\user\models\Profile'
                ],
            ],
            'controllerMap' => [
                'admin' => 'infoweb\user\controllers\AdminController',
                'settings' => 'infoweb\user\controllers\SettingsController'
            ],
            'modules' => [
                // Register the custom module as a submodule
                'infoweb-user' => [
                    'class' => 'infoweb\user\Module'
                ]
            ]
        ],
    ]
];
```

and your common configuration as follows:
```
'as access' => [
    'class' => 'infoweb\user\components\AccessControl',
    'user' => 'infoweb\user\models\WebUser'
],
```

To use the module, execute yii migration
```
yii migrate/up --migrationPath=@vendor/infoweb-internet-solutions/yii2-cms-user/migrations
yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
```
