<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tour_lang".
 *
 * @property string $id
 * @property string $tour_id
 * @property string $language
 * @property string $title
 * @property string $description
 *
 * @property Tour $tour
 */
class TourLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tour_id', 'language', 'title', 'description'], 'required'],
            [['tour_id'], 'integer'],
            [['language', 'description'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tour_id' => Yii::t('app', 'Tour ID'),
            'language' => Yii::t('app', 'Language'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tour::className(), ['id' => 'tour_id']);
    }
}
