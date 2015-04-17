<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use infoweb\user\models\Profile;
use infoweb\user\assets\frontend\SignupAsset;

SignupAsset::register($this);

$this->title = 'Chiesi College';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vel rutrum tortor, ut eleifend felis. Nam viverra eget odio eget gravida. In feugiat efficitur leo sed dictum. Duis quis dignissim mauris, non laoreet quam. Aliquam erat volutpat. Aliquam commodo sem vel enim dictum, id vestibulum quam cursus. Sed finibus nisi in dolor interdum tincidunt. Suspendisse quis purus ac nunc condimentum vestibulum. Duis sagittis mauris eget ullamcorper vulputate. Nunc vulputate nibh non purus commodo, quis sagittis nunc laoreet. 
    </p>
    <div class="row">
        <div class="col-sm-8">
            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false
            ]); ?>
            
                <?php // User specific fields ?>
                <?= $form->field($model, 'salutation')->inline()->radioList([
                    Profile::SALUTATION_MR => Yii::t('infoweb/user', 'Mr.'),
                    Profile::SALUTATION_MS => Yii::t('infoweb/user', 'Ms.')    
                ]) ?>                
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'name', ['enableError' => false]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'firstname', ['enableError' => false]) ?>
                    </div>
                </div>              
                <?= $form->field($model, 'email') ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'address', ['enableError' => false]) ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($model, 'zipcode') ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'city') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'phone') ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'mobile') ?>
                    </div>
                </div>                
                <?= $form->field($model, 'profession', ['enableError' => false])->dropDownList($professions, [
                    'prompt' => Yii::t('infoweb/user', 'Select your profession')
                ]) ?>
                
                <?php // Profession specific fields ?>
                <?= $form->field($model, 'responsible_pneumologist')->textInput() ?>
                <div class="row container-workplace-fields">
                    <div class="col-sm-3">
                        <?= $form->field($model, 'workplace_type')->dropDownList([
                            Profile::WORKPLACETYPE_HOSPITAL => Yii::t('infoweb/user', 'Hospital'),
                            Profile::WORKPLACETYPE_PRIVATE => Yii::t('infoweb/user', 'Private practice')    
                        ]) ?>
                    </div>
                    <div class="col-sm-9">
                        <?= $form->field($model, 'workplace_name', ['enableError' => false])->label('&nbsp;')->textInput() ?>                            
                    </div>
                </div>
                <?= $form->field($model, 'riziv_number', ['enableError' => false])->textInput() ?>
                <?= $form->field($model, 'apb_number', ['enableError' => false])->textInput() ?>                
                
                <?php // Account fields ?>
                <?= $form->field($model, 'username') ?>                
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                    </div>
                </div>
                
                <?php // Legal fields ?>
                <?= $form->field($model, 'agree_user_terms', ['enableError' => false])->checkbox() ?>
                <?= $form->field($model, 'read_privacy_policy', ['enableError' => false])->checkbox() ?>
                <?= $form->field($model, 'profession_declaration', ['enableError' => false])->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
