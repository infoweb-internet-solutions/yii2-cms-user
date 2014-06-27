# Yii2-user


Add this to your config:

'components' => [
  ...
  'view' => [
      'theme' => [
          'pathMap' => [
              '@dektrium/user/views' => '@infoweb/user/views'
          ],
      ],
  ],
],
'modules' => [
  'user' => [
    'controllerMap' => [
      'admin' => 'infoweb\user\controllers\AdminController'
    ],    
    'components' => [
      'manager' => [
        'userClass' => 'infoweb\user\models\User',
      ],
    ],
  ],
],


Most of web applications provide a way for users to register, log in or reset their forgotten passwords. Rather than
re-implementing this on each application, you can use Yii2-user which is a flexible user management module for Yii2 that
handles common tasks such as registration, authentication and password retrieval. Current version includes following features:

* Registration with an optional confirmation per mail
* Registration via social networks
* Password retrieval
* Account and profile management
* Console commands
* User management interface

> **NOTE:** Module is in initial development. Anything may change at any time.

## Documentation

Yii2-user documentation is available online: [Read the documentation](http://yii2-user.readthedocs.org/en/latest/).
Installation instructions are located in [installation guide](http://yii2-user.readthedocs.org/en/latest/getting-started/installation.html).

## Contributing

Contributing instructions are located in [CONTRIBUTING.md](CONTRIBUTING.md) file.

## License

Yii2-user is released under the MIT License. See the bundled [LICENSE.md](LICENSE.md) for details.

test
