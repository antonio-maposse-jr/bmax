<?php

namespace App\Models;

use App\Models\Traits\LogsActivity;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use CrudTrait;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'customers';
    protected $guarded = ['id'];
 

    public function customerCategory(){
        return $this->belongsTo(CustomerCategory::class);
    }

    public function notifications()
    {
        return $this->hasMany(CustomerSystemNotification::class, 'customer_id');
    }

    public function processes(){
        return $this->hasMany(Process::class, 'customer_id');
    }
 
}
