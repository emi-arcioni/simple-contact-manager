<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends CRUDController
{
    protected $model;
    protected $label;
    protected $form_validator_fields;
    protected $form_data;

    public function __construct(Setting $model) {
        $this->model = $model;
        $this->label = 'Setting';
    }

    public function form(Request $request, $setting_id = NULL)
    {
        $setting = Setting::where('user_id', auth()->user()->id)->first();
        return parent::form($request, $setting->id ?? NULL);
    }

    public function store(Request $request, $contact_id = NULL)
    {
        $this->form_validator_fields = [
            'klaviyo_api' => ['required']
        ];
        $this->form_data = [
            'user_id' => auth()->user()->id,
            'content' => json_encode([
                'klaviyo_api' => $request->input('klaviyo_api')
            ])
        ];

        return parent::store($request, $contact_id);
    }
}
