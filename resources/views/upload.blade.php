@extends('adminlte::page')

@section('title', 'LaunchCart Challenge')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">Upload CSV</h1>
        </div>
        <div class="col-auto">
            <a class="btn btn-danger" href="/contacts">Cancel</a>
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
                <form role="form" method="POST" action="/contacts/upload" autocomplete="off" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="inputFile">File</label>
                                    <div class="custom-file">
                                        <input type="file" name="file" class="custom-file-input" id="customFile" accept=".csv">
                                        <label class="custom-file-label" for="customFile">Browse file</label>
                                    </div>
                                    @error('file')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!-- /row -->
                    </div><!-- /card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div> <!-- /card -->
        </div><!-- /col-12 -->
    </div><!-- /row -->
@stop

@section('js')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@stop