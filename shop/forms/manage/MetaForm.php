<?php
namespace shop\forms\manage;


use shop\entities\Meta;
use yii\base\Model;

class MetaForm extends Model
{
    public $title;
    public $description;
    public $robots;

    public function __construct(Meta $meta = null, $config = [])
    {
        if ($meta){
            $this->title = $meta->title;
            $this->description = $meta->description;
            $this->robots = $meta->robots;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['robots'], 'safe'],
        ];
    }
}