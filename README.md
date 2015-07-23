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
        // Add to views
        'view' => [
            'theme' => [
                'pathMap' => [
					...
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
            'modelMap' => [
                'User' => 'infoweb\user\models\User',
                'UserSearch' => 'infoweb\user\models\UserSearch',
                'Profile' => 'infoweb\user\models\Profile',
            ],
            'controllerMap' => [
                'admin' => 'infoweb\user\controllers\AdminController',
                'settings' => 'infoweb\user\controllers\SettingsController',
                'security' => 'infoweb\user\controllers\SecurityController',
            ],
            'modules' => [
                // Register the custom module as a submodule
                'infoweb-user' => [
                    'class' => 'infoweb\user\Module'
                ]
            ]
        ],
    ],
    ...
    'as access' => [
        'class' => 'infoweb\user\components\AccessControl',
        'user' => 'infoweb\user\models\WebUser',
        'allowActions' => [
            'user/recovery/*',
            'user/security/logout',
            'user/registration/*'
        ],
    ],
];
```

To use the module, execute yii migration
```
yii migrate/up --migrationPath=@vendor/infoweb-internet-solutions/yii2-cms-user/migrations
yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
```

Separate frontend and backend user
----------------------------------
If you want to use separate sessions for users of the frontend and backend application, a couple of configurations have to be updated.

1. Bootstrap the **session** component in `backend/config/main.php`
   ```php
   'bootstrap' => ['session'...],
   ```

2. Set the **identityCookie** of the **user** component and update the **request** and **session** components in `backend/config/main.php`
   ```php
   'components' => [
       ...
       'user' => [
           ...          
           'identityCookie' => [
               'name' => '_backendIdentity',
               'path' => '/admin',
               'httpOnly' => true,
           ],
       ],
       ...
       'request' => [
            'class' => 'common\components\Request',
            'web'=> '/backend/web',
            'adminUrl' => '/admin',
            'csrfParam' => '_backendCSRF',
        ],
        'session' => [
            'name' => 'PHPSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path' => '/admin',
            ],
        ],
        ...
   ]
   ```
   
3. Bootstrap the **session** component in `frontend/config/main.php`
   ```php
   'bootstrap' => ['session'...],
   ```
   
4. Update the **user**, **request** and **session** components in `frontend/config/main.php`
   ```php
   ...
   'user' => [
       'identityClass' => 'infoweb\user\models\frontend\User',
       'enableAutoLogin' => true,
       'identityCookie' => [
           'name' => '_frontendIdentity',
           'path' => '/',
           'httpOnly' => true,
       ],
   ],
   'request'=>[
       'class' => 'common\components\Request',
       'web' => '/frontend/web',
       'csrfParam' => '_frontendCSRF',
   ],
   'session' => [
       'name' => 'PHPFRONTSESSID',
       'cookieParams' => [
           'httpOnly' => true,
           'path' => '/',
       ],
   ],
   ...
   ```
   
5. At this point you can implement the `models/frontend/LoginForm.php` and `models/frontend/SignupForm.php` models and create views and controller actions for them.

6. Some sort of access control has to be implemented in your frontend controllers to determine which actions are allowed for a frontend user. This can be done through a rbac role of by implementing an access filter as a behavior.

```php
public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [                    
                // Login and signup pages are accessible for guests
                [
                    'actions' => ['login','signup', 'request-password-reset'],
                    'allow' => true,
                    'roles' => ['?','@'],
                ],
                // Logout page is accessible for authenticated users
                [
                    'actions' => ['logout'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                // These actions are accessible for authenticated users
                [
                    'actions' => [...],
                    'allow' => true,
                    'roles' => ['@'],
                ],
				...
            ],
            // If access is denied, redirect to the login page
            'denyCallback' => function ($rule, $action) {
                $this->redirect(['/'])->send();
            }
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ],
    ];
}
```