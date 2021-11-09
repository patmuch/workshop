<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = [
        'fname', 'lname','email', 'phone', 'contact_type_id'
    ];
    public function contactType()
    {
        return $this->belongsTo('App\Models\ContactType');
    }
}
