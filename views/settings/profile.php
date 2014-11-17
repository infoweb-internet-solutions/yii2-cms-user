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
use kartik\widgets\FileInput;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;

$initialPreview = [];
$initialCaption = '';

if (strlen($model->user->getImage()->name) > 0) {
    $initialPreview = [
        Html::img($model->user->getImage()->getUrl(), ['class' => 'file-preview-image', 'alt' => $model->user->getImage()->alt, 'title' => $model->user->getImage()->alt]),
    ];

    $initialCaption = $model->user->getImage()->name;
}
?>

<?= $this->render('/_alert') ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'profile-form',
                    'fieldConfig' => [
                        'template' => "{label}\n<div>{input}</div>\n<div>{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'control-label'],
                    ],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>

                <?= $form->field($model, 'name') ?>
                
                <?= $form->field($image, 'image[]')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                    ],
                    'pluginOptions' => [
                        'initialPreview' => $initialPreview,
                        'showPreview' => true,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        'initialCaption' => $initialCaption,
                    ],
                    'pluginEvents' => [
                        "fileclear" => "function() {
                            var request = $.post('remove-images', {model: '{$model->user->id}'});
                            
                            request.done(function(response) {
               
                            });
                        }"
                    ]
                ]) ?>

                <div class="form-group">
                    <div>
                        <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?><br>
                    </div>
                </div>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
