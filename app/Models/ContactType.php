<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    //
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }
}
