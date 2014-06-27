<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Tour */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tour',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tours'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>
<div class="tour-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    $languages = new stdClass();
    $languages->nl = new stdClass();
    $languages->en = new stdClass();
    $languages->nl->code = 'nl';
    $languages->en->code = 'en';
    ?>

    <?php foreach ($languages as $language): ?>
        <?php
        $model->language = $language->code;
        // attach the language as an attribute (it is a ModelLang type of entity)
        $model->getBehavior('trans')->translationAttributes[] = $language->code;
        $items[] = [
            'label' => $language->code,
            'content' => $this->render('_translation_item', ['model' => $model])
        ];
        ?>
    <?php endforeach; ?>


    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'General Info',
                // here the default language
                'content' => $this->render('_form', ['model' => $model])
            ],
            [
                // here translation edited via AJAX
                'label' => 'Translations',
                'content' =>  $this->render('_translations_form', ['model' => $model])
            ],
        ],
    ]);?>

</div>