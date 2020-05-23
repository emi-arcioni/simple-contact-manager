@extends('adminlte::page')

@section('title', 'LaunchCart Challenge')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">{{ $item ? 'Edit' : 'New' }} Contact</h1>
        </div>
        <div class="col-auto">
            <a class="btn btn-danger" href="/contacts">Cancel</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form role="form" method="POST" action="/contacts{{ $item ? '/' . $item['id'] : '' }}" autocomplete="off" enctype="multipart/form-data">
                    @if ($item)
                        <input type="hidden" name="_method" value="PUT">
                    @endif
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="firstNameInput">First Name</label>
                                    <input name="first_name" value="{{ old('first_name', optional($item)->first_name) }}" type="text" class="form-control {{ $errors->get('first_name') ? 'is-invalid' : '' }}" id="firstNameInput">
                                    @error('first_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="emailInput">Email</label>
                                    <input name="email" value="{{ old('email', optional($item)->email) }}" type="text" class="form-control {{ $errors->get('email') ? 'is-invalid' : '' }}" id="emailInput">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="phoneInput">Phone number</label>
                                    <input name="phone" value="{{ old('phone', optional($item)->phone) }}" type="text" class="form-control {{ $errors->get('phone') ? 'is-invalid' : '' }}" id="phoneInput">
                                    @error('phone')
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