<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload($user_id, $abonent_id)
    {
        if ($this->validate()) {
            $prePath = $this->preparePath($user_id, $abonent_id);
            $fullPath = $prePath . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($fullPath);
            return $fullPath;
        } else {
            return false;
        }
    }
    
    protected function preparePath($user_id, $abonent_id) {
        
        $path = 'uploads/users/' . $user_id . '/members/' . $abonent_id . '/';
        if(!is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        return $path;
    }
    
   
}
