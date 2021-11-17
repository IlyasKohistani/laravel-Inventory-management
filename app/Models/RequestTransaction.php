<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'product_id', 'quantity', 'stock', 'description', 'status', 'approved_at', 'approved_by'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function approved_user(){
        return $this->belongsTo(User::class,'approved_by');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
