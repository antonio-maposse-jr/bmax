<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionTask extends Model
{
    use HasFactory;

    protected $fillable = ['process_id'];
}
