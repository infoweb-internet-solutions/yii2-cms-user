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

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    'components' => [
        ...        
        // Override views
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@infoweb-internet-solutions/user/views'
                ]
            ]
        ]
    ],
    ...
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['infoweb', 'admin'],
            'components' => [
                'manager' => [
                    'userClass' => 'infoweb-internet-solutions\user\models\User'
                ]
            ],
            'controllerMap' => [
                'admin' => 'infoweb-internet-solutions\user\controllers\AdminController'
            ],
        ],
    ]
];
```

To use the module, execute yii migration
```
yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
```