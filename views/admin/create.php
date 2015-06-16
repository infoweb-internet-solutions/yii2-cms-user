<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 */

$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'username')->textInput(['maxlength' => 25, 'autofocus' => true]) ?>

        <?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($user, 'password')->passwordInput() ?>

        <div class="form-group field-user-role">
            <label for="user-role" class="control-label"><?= Yii::t('app', 'Role') ?></label>
            <?= Html::dropDownList('roles', '', ArrayHelper::map($roles, 'name', 'description'), ['class' => 'form-control', 'multiple' => 'true', 'style' => 'height: 150px;']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
