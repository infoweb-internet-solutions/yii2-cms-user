<?php

namespace frontend\controllers;

use Yii;
use common\models\News;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * Displays all News models.
     * @param string $id
     * @return mixed
     */
    public function actionIndex($id = 5)
    {
        $model = new News($id);

        //$model

        return $this->render('index', [
            'model' => $model //$this->findModel($id),
        ]);
    }

  
}