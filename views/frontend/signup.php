<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use infoweb\user\models\frontend\User;
use infoweb\user\assets\frontend\SignupAsset;

SignupAsset::register($this);

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-sm-8">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'salutation')->radioList([
                    User::SALUTATION_MR => Yii::t('infoweb/user', 'Mr.'),
                    User::SALUTATION_MS => Yii::t('infoweb/user', 'Ms.')    
                ]) ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'firstname') ?>                
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'profession')->dropDownList($professions, [
                    'prompt'    => Yii::t('infoweb/user', 'Select your profession')
                ]) ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
