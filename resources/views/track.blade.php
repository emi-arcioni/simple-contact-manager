@extends('adminlte::page')

@section('title', 'LaunchCart Challenge')

@section('content_header')
    <h1 class="m-0 text-dark">Track</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-{{ $type }} mb-0">
                        {{ $message }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
