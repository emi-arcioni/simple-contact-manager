<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CRUDController extends Controller
{
    protected $model;
    protected $label;
    protected $form_validator_fields;
    protected $form_data;
    protected $item;

    public function index(Request $request) 
    {
        $items = $this->model->where('user_id', auth()->user()->id)->get();
        $view_data = [
            'items' => $items
        ];

        return view(Str::plural(mb_strtolower($this->label)), $view_data);
    }

    public function form(Request $request, $item_id = NULL)
    {
        if ($item_id) {
            $item = $this->model->where('user_id', auth()->user()->id)->where('id', $item_id)->firstOrFail();
        } else {
            $item = [];
        }

        $view_data = [
            'item' => $item
        ];

        return view(mb_strtolower($this->label), $view_data);
    }

    public function store(Request $request, $item_id = NULL)
    {
        Validator::make($request->all(), $this->form_validator_fields)->validate();

        $item = $this->model->updateOrCreate(
            ['id' => $item_id, 'user_id' => auth()->user()->id],
            $this->form_data
        );
        if ($item->wasRecentlyCreated) {
            $message = 'The ' . mb_strtolower($this->label) . ' has been succesfully created';
            $type = 'success';
        } else {
            $message = 'The ' . mb_strtolower($this->label) . ' has been succesfully updated';
            $type = 'success';
        }

        $this->item = $item;

        return redirect('/' . Str::plural(mb_strtolower($this->label)))->with($type, $message);
    }

    public function delete(Request $request, $item_id)
    {
        $item = $this->model->where('user_id', auth()->user()->id)->where('id', $item_id)->firstOrFail();
        $this->item = $item;
        $item->delete();

        return redirect('/' . Str::plural(mb_strtolower($this->label)))->with('success', 'The ' . mb_strtolower($this->label) . ' has been succesfully removed');
    }
}
