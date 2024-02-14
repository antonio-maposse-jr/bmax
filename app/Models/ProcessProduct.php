<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'process_products';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function process(){
        return $this->belongsTo(Process::class);
    }
}
