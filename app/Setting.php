<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'content'
    ];

    public function getContentAttribute() {
        return $this->attributes['content'] ? json_decode($this->attributes['content'], true) : NULL;
    }
}
