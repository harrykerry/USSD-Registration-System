<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventRegistration extends Model


{
    use HasFactory;

    protected $table = 'event_registrations';
    protected $fillable = ['First_Name','Second_Name','Church_Name','mobile'];

    public function userData($data){

    $this->First_Name = $data['FirstName'];
    $this->Second = $data['SecondName'];
    $this->Church_Name = $data['ChurchName'];
    $this->mobile = $data['mobile'];

    return $this->save() ? true : false;

    }
}
