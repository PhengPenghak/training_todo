<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property string $image_url
 * @property string|null $sub_title
 * @property string|null $description
 * @property int|null $status
 * @property string|null $created_at
 * @property int|null $updated_by
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */

    public $imageFile;
    public function rules()
    {
        return [
            [['title', 'price', 'image_url'], 'required'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['status', 'updated_by'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'image_url', 'sub_title'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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
            'price' => 'Price',
            'image_url' => 'Image Url',
            'sub_title' => 'Sub Title',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
