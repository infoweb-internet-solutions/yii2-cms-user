<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
// Dit werkt normaal vanzelf als ge installeerd via composer
Yii::setAlias('infoweb/user', dirname(dirname(__DIR__)) . '/vendor/infoweb/yii2-user');