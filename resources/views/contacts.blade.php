@extends('adminlte::page')

@section('title', 'LaunchCart Challenge')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">Contacts</h1>
        </div>
        <div class="col-auto">
            <a class="btn btn-primary" href="/contacts/new">Add new contact</a>
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
            @if (count($items) > 0)
            <div class="card">
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>E-mail</th>
                                <th>Phone</th>
                                <th>Date created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $contact)
                            <tr>
                                <td class="align-middle">{{ $contact['first_name'] }}</td>
                                <td class="align-middle">{{ $contact['email'] }}</td>
                                <td class="align-middle">{{ $contact['phone'] }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($contact['created_at'])->format("m/d/Y H:i:s") }} (GMT)</td>
                                <td class="align-middle" style="width: 15%">
                                    <a href="/contacts/{{ $contact['id'] }}" class="btn btn-sm btn-secondary">Edit</a>
                                    <button type="button" 
                                    data-toggle="modal" 
                                    data-target="#modal-remove-{{ $contact['id'] }}"
                                    class="btn btn-sm btn-danger">Delete</button>

                                    <!-- TODO: get this modal out of foreach and use a unique modal for all deletions -->
                                    <div class="modal fade" id="modal-remove-{{ $contact['id'] }}">
                                        <form method="POST" action="/contacts/{{ $contact['id'] }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header text-danger">
                                                        <h4>Warning</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>The contact {{ $contact['email'] }} will be removed. ¿Are you sure?</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">No, cancel</button>
                                                        <button type="submit" class="btn btn-danger" data-proceed>Yes, remove</button>
                                                    </div>
                                                </div><!--modal-content-->
                                            </div><!--modal-dialog-->
                                        </form>
                                    </div><!--modal-->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!--card-body-->
            </div><!--card-->
            @else
                No data were found.
            @endif
        </div><!--col-->
    </div><!--row-->
@stop
