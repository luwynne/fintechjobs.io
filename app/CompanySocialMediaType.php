<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySocialMediaType extends Model
{
    public $timestamps = false;

    protected $table = 'company_social_media_types';

    public function companies(){
        return $this->hasMany(CompanySocialMedia::class, 'type_id');
    }
}
