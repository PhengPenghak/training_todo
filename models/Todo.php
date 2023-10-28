<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todo".
 *
 * @property int $id
 * @property string $title
 * @property int|null $status
 * @property string|null $create_at
 * @property string|null $date
 */
class Todo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'todo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['create_at', 'date'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'create_at' => 'Create At',
            'date' => 'Date',
        ];
    }
}
