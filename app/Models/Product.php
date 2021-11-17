<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $appends = ['image_link'];

    protected $fillable = ['id', 'name', 'category_id', 'sub_category_id', 'article_code', 'quantity', 'status', 'image'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'image',
    ];

    public function getImageLinkAttribute()
    {
        $params = ['product' => $this->id];
        return  URL::temporarySignedRoute('product.image', now()->addMinutes(ENV('SIGNED_URL_EXPIRATION_TIME')), $params);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
