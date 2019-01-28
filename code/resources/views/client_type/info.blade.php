@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">@if($id == 'new') Add New Client Type @else Edit Client Type @endif</div>
                    <div class="card-body">
                        <form action="{{ url('client_type/save/'.$id) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="type">{{ ucwords(str_replace("_"," ","type")) }}</label>
                                <input type="text" class="form-control" id="type" name="type" @if($id != 'new') value="{{ $field->type }}" @endif required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ ucwords(str_replace("_"," ","description")) }}</label>
                                <input type="text" class="form-control" id="description" name="description" @if($id != 'new') value="{{ $field->description }}" @endif required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Client type</button>
                                <a href="{{ url('client_type') }}" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
