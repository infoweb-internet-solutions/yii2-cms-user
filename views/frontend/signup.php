<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use infoweb\user\models\Profile;
use infoweb\user\assets\frontend\SignupAsset;

SignupAsset::register($this);
?>
<?php $form = ActiveForm::begin([
    'id' => 'form-signup',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false
]); ?>

    <?php // User specific fields ?>
    <?= $form->field($model, 'salutation')->inline()->radioList([
        Profile::SALUTATION_MR => Yii::t('frontend', 'Dhr.'),
        Profile::SALUTATION_MS => Yii::t('frontend', 'Mevr.')    
    ])->label(false) ?>                
    <div class="row">
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'name', ['enableError' => false]) ?>
        </div>
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'firstname', ['enableError' => false]) ?>
        </div>
    </div>              
    <?= $form->field($model, 'email') ?>
    <div class="row">
        <div class="col-md-10 col-xs-24">
            <?= $form->field($model, 'address', ['enableError' => false]) ?>
        </div>
        <div class="col-md-6 col-xs-24">
            <?= $form->field($model, 'zipcode') ?>
        </div>
        <div class="col-md-8 col-xs-24">
            <?= $form->field($model, 'city') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'phone') ?>
        </div>
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'mobile') ?>
        </div>
    </div>
    
    <?= $form->field($model, 'language')->dropDownList($languages) ?>
                    
    <?= $form->field($model, 'profession', ['enableError' => false])->dropDownList($professions, [
        'prompt' => Yii::t('frontend', 'Kies je beroep')
    ]) ?>
    
    <?php // Profession specific fields ?>
    <?= $form->field($model, 'responsible_pneumologist')->textInput() ?>
    <div class="row container-workplace-fields">
        <div class="col-md-6 col-xs-24">
            <?= $form->field($model, 'workplace_type')->dropDownList([
                Profile::WORKPLACETYPE_HOSPITAL => Yii::t('frontend', 'Ziekenhuis'),
                Profile::WORKPLACETYPE_PRIVATE => Yii::t('frontend', 'Privépraktijk')    
            ]) ?>
        </div>
        <div class="col-md-18 col-xs-24">
            <?= $form->field($model, 'workplace_name', ['enableError' => false])->label('&nbsp;')->textInput() ?>                            
        </div>
    </div>
    <?= $form->field($model, 'riziv_number', ['enableError' => false])->textInput() ?>
    <?= $form->field($model, 'apb_number', ['enableError' => false])->textInput() ?>                
    
    <?php // Account fields ?>
    <?= $form->field($model, 'username') ?>                
    <div class="row">
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        </div>
    </div>
    
    <?php // Legal fields ?>
    <?= $form
            ->field($model, 'agree_user_terms', ['enableError' => false])
            ->checkbox()
            ->label(
                Yii::t(
                    'frontend',
                    'Ik ga akkoord met de {gebruikersvoorwaarden}',
                    ['gebruikersvoorwaarden' => Html::a(Yii::t('frontend', 'gebruikersvoorwaarden'), Yii::getAlias('@uploadsBaseUrl/files/gebruiksvoorwaarden.docx'), ['_target' => 'blank'])]
                ),
                ['format' => 'raw']
            ) ?>
    <?= $form
            ->field($model, 'read_privacy_policy', ['enableError' => false])
            ->checkbox()
            ->label(
                Yii::t(
                    'frontend',
                    'Ik heb de {privacy policy} gelezen',
                    ['privacy policy' => Html::a(Yii::t('frontend', 'privacy policy'), Yii::getAlias('@uploadsBaseUrl/files/privacy.docx'), ['_target' => 'blank'])]
                ),
                ['format' => 'raw']
            ) ?>
    <?= $form->field($model, 'profession_declaration', ['enableError' => false])->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('frontend', 'Registreren'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
