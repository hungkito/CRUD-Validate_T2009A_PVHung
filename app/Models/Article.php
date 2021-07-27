<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\exactly;

class Article extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasOne(ArticleCategory::class, 'id', 'category_id');
    }

    public function getListPhotoAttribute(){
        $array_image = [];
        if ($this->thumbnail){
            $array_image = explode(',', $this->thumbnail);
        }
        return $array_image;
    }

    public function getDefaultThumbnailAttribute(){
        $array_image = $this->listPhoto;
        if (count($array_image) > 0){
            return $array_image[0];
        } else {
            return 'https://mcleansmartialarts.com/wp-content/uploads/2017/04/default-image-620x600.jpg';
        }
    }
}
