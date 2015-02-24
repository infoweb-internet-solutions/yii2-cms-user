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

use dektrium\user\controllers\AdminController as BaseAdminController;


use mdm\admin\models;
use yii\helpers\ArrayHelper;
use infoweb\user\models\User;
use Yii;

/**
 * AdminController allows you to administrate users.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class AdminController extends BaseAdminController
{

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed

    public function actionCreate()
    {
        $model = $this->module->manager->createUser(['scenario' => 'create']);
        $manager = \Yii::$app->authManager;
        $post = \Yii::$app->request->post();

        if ($model->load($post) && $model->create()) {

            if (isset($post['roles']))
            {
                // Revoke all roles for this user
                $manager->revokeAll($model->id);

                foreach ($post['roles'] as $role)
                {
                    // Get role object
                    $role = $manager->getRole($role);
                    // Assign the role
                    $manager->assign($role, $model->id);
                }
            }

            \Yii::$app->getSession()->setFlash('admin_user', \Yii::t('user', 'User has been created'));
            return $this->redirect(['index']);
        }

        // Get all roles
        $roles = $manager->getRoles();
        
        // Superadmin can only assign the 'Superadmin' role
        if (isset($roles['Superadmin']) && !\Yii::$app->user->can('Superadmin'))
            unset($roles['Superadmin']);

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }
     */

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $manager = \Yii::$app->authManager;
        
        /** @var User $user */
        $user = Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);

        $this->performAjaxValidation($user);

        if ($user->load(Yii::$app->request->post()) && $user->create()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been created'));
            return $this->redirect(['update', 'id' => $user->id]);
        }

        // Get all roles
        $roles = $manager->getRoles();

        // Superadmin can only assign the 'Superadmin' role
        if (isset($roles['Superadmin']) && !\Yii::$app->user->can('Superadmin'))
            unset($roles['Superadmin']);

        return $this->render('create', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $manager = \Yii::$app->authManager;
        $post = \Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            // Revoke all roles for this user
            $manager->revokeAll($model->id);

            foreach ($post['roles'] as $role)
            {
                // Get role object
                $role = $manager->getRole($role);
                // Assign the role
                $manager->assign($role, $model->id);
            }

            \Yii::$app->getSession()->setFlash('admin_user', \Yii::t('user', 'User has been updated'));
            return $this->refresh();
        }

        // Get all roles
        $roles = $manager->getRoles();
        
        // Superadmin can only assign the 'Superadmin' role
        if (isset($roles['Superadmin']) && !\Yii::$app->user->can('Superadmin'))
            unset($roles['Superadmin']);

        // Get all assigned roles for this user
        $activeRoles = ArrayHelper::map($manager->getAssignments($model->id), 'roleName', 'roleName');

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
            'activeRoles' => $activeRoles,
        ]);
    }
}
