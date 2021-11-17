<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','name'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function grant_transactions(){
        return $this->hasManyThrough(Grant::class,Product::class);
    }

    public function request_transactions(){
        return $this->hasManyThrough(RequestTransaction::class,Product::class);
    }
}
