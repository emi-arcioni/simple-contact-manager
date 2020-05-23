<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'content'
    ];

    public function getContentAttribute() 
    {
        return $this->attributes['content'] ? json_decode($this->attributes['content'], true) : NULL;
    }

    public function scopePrivateApiKey() 
    {
        $user_settings = $this->where('user_id', auth()->user()->id)->first();
        if (!empty($user_settings)) {
            return $user_settings->content['klaviyo_private'];
        } 
        return '';
    }

    public function scopePublicApiKey() 
    {
        $user_settings = $this->where('user_id', auth()->user()->id)->first();
        if (!empty($user_settings)) {
            return $user_settings->content['klaviyo_public'];
        } 
        return '';
    }
}
