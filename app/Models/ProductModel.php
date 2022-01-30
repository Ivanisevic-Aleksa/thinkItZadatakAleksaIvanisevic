<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CategoryModel;

class ProductModel extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'number',
        'name',
        'about',
        'price',
        'image_name',
    ];

    public function category(){
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }
}
