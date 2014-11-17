<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace infoweb\user\controllers;

use yii\web\UploadedFile;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use dektrium\user\controllers\SettingsController as BaseController;
use infoweb\cms\models\ImageUploadForm;

/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SettingsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'disconnect' => ['post'],
                    'removeImages' => ['post']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile', 'account', 'confirm', 'networks', 'connect', 'disconnect', 'removeImages'],
                        'roles'   => ['@']
                    ],
                ]
            ],
        ];
    }
    
    /**
     * Shows profile settings form.
     *
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = $this->module->manager->findProfileById(\Yii::$app->user->identity->getId());

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            
            // Upload image
            $form = new ImageUploadForm;
            $images = UploadedFile::getInstances($form, 'image');
            
            $user = $model->user;

            // Remove old images if a new one is uploaded
            if ($images) {
                $user->removeImages();

                foreach ($images as $k => $image) {

                    $upload = new ImageUploadForm();
                    $upload->image = $image;

                    if ($upload->validate()) {
                        $path = \Yii::getAlias('@uploadsBaseUrl') . "/img/{$upload->image->baseName}.{$upload->image->extension}";

                        $upload->image->saveAs($path);

                        // Attach image to model
                        $user->attachImage($path);

                    } else {
                        foreach ($upload->getErrors('image') as $error) {
                            $model->addError('image', $error);
                        }
                    }
                }
                

                /*if ($model->hasErrors('image')){
                    $model->addError(
                        'image',
                        count($model->getErrors('image')) . Yii::t('app', 'of') . count($images) . ' ' . Yii::t('app', 'images not uploaded')
                    );
                } else {
                    Yii::$app->session->setFlash('employee', Yii::t('app', '{n, plural, =1{Image} other{# images}} successfully uploaded', ['n' => count($images)]));
                }*/    
            }
                        
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Profile settings have been successfully saved'));
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
            'image' => new ImageUploadForm
        ]);
    }

    /**
     * Removes all images that are attached to a model
     * 
     * @param   string      $model
     * @return  string      JSON response
     */
    public function actionRemoveImages()
    {
        // Default response
        $response = [
            'status'    => 1,
            'msg'       => ''
        ];
        
        $post = Yii::$app->request->post();
        
        if (isset($post['model']) && !empty($post['model'])) {
            // Load model
            $model = $this->module->manager->findProfileById(\Yii::$app->user->identity->getId());
            
            // Remove the images
            $model->removeImages();
        }
        
        // Return validation in JSON format
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }
}
