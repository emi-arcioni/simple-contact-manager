@extends('adminlte::page')

@section('title', 'LaunchCart Challenge')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">Edit settings</h1>
        </div>
    </div>
@stop

@section('content')
@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form role="form" method="POST" action="/settings{{ $item ? '/' . $item['id'] : '' }}" autocomplete="off" enctype="multipart/form-data">
                    @if ($item)
                        <input type="hidden" name="_method" value="PUT">
                    @endif
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PrivateAPIKeyInput">Klaviyo Private API Key</label>
                                    <input name="klaviyo_private" value="{{ old('klaviyo_private', optional($item)->content['klaviyo_private']) }}" type="text" class="form-control {{ $errors->get('klaviyo_private') ? 'is-invalid' : '' }}" id="PrivateAPIKeyInput">
                                    @error('klaviyo_private')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PrivateAPIKeyInput">Klaviyo Public API Key</label>
                                    <input name="klaviyo_public" value="{{ old('klaviyo_public', optional($item)->content['klaviyo_public']) }}" type="text" class="form-control {{ $errors->get('klaviyo_public') ? 'is-invalid' : '' }}" id="PrivateAPIKeyInput">
                                    @error('klaviyo_public')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!-- /row -->
                    </div><!-- /card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ $item ? 'Update' : 'Add' }}</button>
                    </div>
                </form>
            </div> <!-- /card -->
        </div><!-- /col-12 -->
    </div><!-- /row -->
@stop