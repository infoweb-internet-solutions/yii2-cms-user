<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tour */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tour',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tours'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
