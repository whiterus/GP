<?php
namespace shop\forms\manage\shop\Product;


use shop\entities\shop\product\Product;
use shop\entities\shop\Tag;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class TagsForm extends Model
{
    public $existing = [];
    //public $textNew;

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->existing = ArrayHelper::getColumn($product->tagRelation, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            //['existing', 'each', 'rule' => ['integer']],
            [['existing'], 'safe'],
            //['textNew', 'string'],
        ];
    }

    public function tagsList(): array
    {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function getNewNames(): array
    {
        return array_map('trim', preg_split('#\s*,\s*#i', $this->textNew));
    }

    public function beforeValidate(): bool
    {
        $this->existing = array_filter((array)$this->existing);
        return parent::beforeValidate();
    }
}