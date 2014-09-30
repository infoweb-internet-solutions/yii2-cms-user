<?php

/*
* This file is part of the Dektrium project.
*
* (c) Dektrium project <http://github.com/dektrium/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace infoweb\user\models;

use dektrium\user\models\UserSearch as BaseUserSearch;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about User.
 */
class UserSearch extends BaseUserSearch
{
    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        
        // Don't show super admin for other users
        if (!Yii::$app->user->can('superAdmin')) {
            // The superadmin id is loaded from the 'infoweb-user' submodule
            $query->andWhere('id != :id', ['id' => Yii::$app->getModule('user')->getModule('infoweb-user')->params['superAdminId']]);
        }        
                
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'username', true);
        $this->addCondition($query, 'email', true);
        $this->addCondition($query, 'created_at');
        $this->addCondition($query, 'registered_from');
        
        return $dataProvider;
    }
}
