<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use infoweb\user\models\Profile;
use infoweb\user\assets\frontend\SignupAsset;

SignupAsset::register($this);
?>
<?php if (Yii::$app->getSession()->hasFlash('signup')): ?>
<div class="alert alert-success">
    <?= Yii::$app->getSession()->getFlash('signup') ?>
</div>
<?php endif; ?>

<?php if (Yii::$app->getSession()->hasFlash('signup-error')): ?>
<div class="alert alert-danger">
    <?= Yii::$app->getSession()->getFlash('signup-error') ?>
</div>
<?php endif; ?>
<?php $form = ActiveForm::begin([
    'id' => 'form-signup',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false
]); ?>

    <?= $form->field($model, 'ref')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'repId')->hiddenInput()->label(false) ?>

    <?php // User specific fields ?>
    <?= $form->field($model, 'salutation')->inline()->radioList([
        Profile::SALUTATION_MR => Yii::t('frontend', 'Dhr.'),
        Profile::SALUTATION_MS => Yii::t('frontend', 'Mevr.')
    ])->label(false) ?>
    <div class="row">
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'name', ['enableError' => false])->label($model->getAttributeLabel('name').' *') ?>
        </div>
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'firstname', ['enableError' => false])->label($model->getAttributeLabel('firstname').' *') ?>
        </div>
    </div>
    <?= $form->field($model, 'email')->label($model->getAttributeLabel('email').' *') ?>
    <div class="row">
        <div class="col-md-10 col-xs-24">
            <?= $form->field($model, 'address', ['enableError' => false])->label($model->getAttributeLabel('address').' *') ?>
        </div>
        <div class="col-md-6 col-xs-24">
            <?= $form->field($model, 'zipcode', ['enableError' => false])->label($model->getAttributeLabel('zipcode').' *') ?>
        </div>
        <div class="col-md-8 col-xs-24">
            <?= $form->field($model, 'city', ['enableError' => false])->label($model->getAttributeLabel('city').' *') ?>
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

    <?= $form->field($model, 'language')->dropDownList($languages)->label($model->getAttributeLabel('language').' *') ?>

    <?= $form->field($model, 'profession', ['enableError' => false])->dropDownList($professions, [
        'prompt' => Yii::t('frontend', 'Kies je beroep')
    ])->label($model->getAttributeLabel('profession').' *') ?>

    <?php // Profession specific fields ?>
    <?= $form->field($model, 'responsible_pneumologist')->textInput() ?>
    <div class="row container-workplace-fields">
        <div class="col-md-6 col-xs-24">
            <?= $form->field($model, 'workplace_type')->dropDownList([
                Profile::WORKPLACETYPE_HOSPITAL => Yii::t('frontend', 'Ziekenhuis'),
                Profile::WORKPLACETYPE_PRIVATE => Yii::t('frontend', 'Privépraktijk')
            ])->label($model->getAttributeLabel('workplace_type').' *') ?>
        </div>
        <div class="col-md-18 col-xs-24">
            <?= $form->field($model, 'workplace_name', ['enableError' => false])->label('&nbsp;')->textInput() ?>
        </div>
    </div>
    <?= $form
            ->field($model, 'riziv_number', ['enableError' => false])
            ->textInput()
            ->label($model->getAttributeLabel('riziv_number').' *')
            ->hint(Yii::t('frontend', 'Structuur').': X-XXXXX-XX-XXX')
    ?>
    <?= $form
            ->field($model, 'apb_number', ['enableError' => false])
            ->textInput()
            ->label($model->getAttributeLabel('apb_number').' *')
            ->hint(Yii::t('frontend', 'Structuur').': XXXXXX')
    ?>

    <?php // Account fields ?>
    <?= $form->field($model, 'username')->label($model->getAttributeLabel('username').' *') ?>
    <div class="row">
        <div class="col-md-12 col-xs-24">
            <?= $form
                    ->field($model, 'password')
                    ->passwordInput()
                    ->label($model->getAttributeLabel('password').' *')
                    ->hint(Yii::t('frontend', 'Moet uit minstens 6 karakters bestaan waarvan minstens 1 cijfer en 1 van de volgende speciale karakters {characters}', ['characters' => '!@#$%^&*']))
            ?>
        </div>
        <div class="col-md-12 col-xs-24">
            <?= $form->field($model, 'password_repeat')->passwordInput()->label($model->getAttributeLabel('password_repeat').' *') ?>
        </div>
        <div class="col-md-24 col-xs-24">
            <p class="help-block">* <?= Yii::t('frontend', 'Verplichte gegevens') ?></p>
        </div>
    </div>

    <?php // Legal fields ?>
    <?= $form->field($model, 'profession_declaration', ['enableError' => false])->checkbox() ?>

    <div class="form-group">
        <?= Yii::t('frontend', 'Uw gegevens worden verwerkt in...') ?>
    </div>
    <div class="form-group">
        <?= Html::a(Yii::t('frontend', 'Privacybeleid'), Yii::getAlias('@uploadsBaseUrl/files/'.Yii::t('frontend', 'bestandsnaam privacy policy')), ['target' => '_blank']) ?>
        &nbsp;-&nbsp;
        <?= Html::a(Yii::t('frontend', 'Cookie policy'), Yii::getAlias('@uploadsBaseUrl/files/'.Yii::t('frontend', 'bestandsnaam privacy policy')), ['target' => '_blank']) ?>
        &nbsp;-&nbsp;
        <?= Html::a(Yii::t('frontend', 'Gebruikersvoorwaarden'), Yii::getAlias('@uploadsBaseUrl/files/'.Yii::t('frontend', 'bestandsnaam gebruiksvoorwaarden')), ['target' => '_blank']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('frontend', 'Registreren'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
