@extends('adminlte::page')

@section('title', 'LaunchCart Challenge')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">You are logged in!</p>
                </div>
            </div>
            @if (!env('KLAVIYO_URL'))
                <div class="alert alert-warning">
                    In order of the correct functionality of Contracts section, you must define <strong>KLAVIYO_URL</strong> variable in your <strong>.env</strong> file
                </div>
            @endif
            @if (!$api_key)
                <div class="alert alert-warning">
                    You must add a Klaviyo API KEY within the Settings section
                </div>
            @endif
        </div>
    </div>
@stop
