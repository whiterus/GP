<?php
namespace shop\forms\manage\shop;


use shop\entities\shop\Tag;
use shop\validators\SlugValidator;
use yii\base\Model;

class TagForm extends Model
{
    public $name;
    public $slug;

    private $_tag;

    public function __construct(Tag $tag = null, array $config = [])
    {
        if ($tag){
            $this->name = $tag->name;
            $this->slug = $tag->slug;

            $this->_tag = $tag;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name'], 'string', 'max' => 60],
            [['slug'], 'string'],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Tag::class, 'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : null]
        ];
    }
}