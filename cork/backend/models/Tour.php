<?php

namespace app\models;

use Yii;
use dosamigos\translateable\TranslateableBehavior;


/**
 * This is the model class for table "tour".
 *
 * @property string $id
 * @property integer $active
 * @property string $time_created
 * @property string $time_updated
 */
class Tour extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'time_created', 'time_updated'], 'required'],
            [['active'], 'integer'],
            [['time_created', 'time_updated'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'active' => Yii::t('app', 'Active'),
            'time_created' => Yii::t('app', 'Time Created'),
            'time_updated' => Yii::t('app', 'Time Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(TourLang::className(), ['tour_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            'trans' => [ // name it the way you want
                'class' => TranslateableBehavior::className(),
                // in case you named your relation differently, you can setup its relation name attribute
                // 'relation' => 'translations',
                // in case you named the language column differently on your translation schema
                // 'languageField' => 'language',
                'translationAttributes' => [
                    'title', 'description'
                ]
            ],
        ];
    }
}
