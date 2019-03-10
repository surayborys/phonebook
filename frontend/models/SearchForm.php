<?php

namespace frontend\models;

use Yii;
use yii\base\Model;



/**
 * Search Form
 *
 * @author suray
 */
class SearchForm extends Model {
    
    const MIN_KEY_LENGTH = 2;
    public $keyword;
    
    
    
    public function rules()
    {
        return [
            // keyword is required
            ['keyword', 'required'],
            // trim keyword
            ['keyword', 'trim'],
            // min length 2
            ['keyword', 'string', 'min'=> self::MIN_KEY_LENGTH],
        ];
    }
    
    public function test(){
        $query = Abonent::findAll();
        return $query;
    }
}
