<?php

namespace App\Models;

use App\Models\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnStage extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;


    public function user(){
        return $this->belongsTo(User::class);
    }
}
