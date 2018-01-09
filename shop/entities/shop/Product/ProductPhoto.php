<?php
namespace shop\entities\shop\product;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class ProductPhoto
 * @package shop\entities\shop\category
 * @property integer $id
 * @property string $file
 * @property integer $sort
 *
 * @mixin ImageUploadBehavior
 */
class ProductPhoto extends ActiveRecord
{

    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public static function tableName(): string
    {
        return '{{shop_photos}}';
    }


    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'imageUpload',
                'thumbs' => [
                    'thumb' => ['width' => 400, 'height' => 300],
                ],
                'filePath' => '@webroot/images/[[pk]].[[extension]]',
                'fileUrl' => '/images/[[pk]].[[extension]]',
                'thumbPath' => '@webroot/images/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '/images/[[profile]]_[[pk]].[[extension]]',
            ],
        ];
    }

}