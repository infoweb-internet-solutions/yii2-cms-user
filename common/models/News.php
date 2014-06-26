<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property string $id
 * @property string $title
 * @property string $text
 * @property integer $active
 * @property string $time_created
 * @property string $time_updated
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'active', 'time_created', 'time_updated'], 'required'],
            [['active'], 'integer'],
            [['time_created', 'time_updated'], 'safe'],
            [['title', 'text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'active' => 'Active',
            'time_created' => 'Time Created',
            'time_updated' => 'Time Updated',
        ];
    }
}
