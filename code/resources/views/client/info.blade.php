@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">@if($id == 'new') Add New Client @else Edit Client @endif</div>
                    <div class="card-body">
                        <form action="{{ url('client/save/'.$id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="name">{{ ucwords(str_replace("_"," ","name")) }}</label>
                                        <input type="text" class="form-control" id="name" name="name" @if($id != 'new') value="{{ $field->name }}" @endif required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">{{ ucwords(str_replace("_"," ","type")) }}</label>
                                        <input type="text" class="form-control" id="type" name="type" @if($id != 'new') value="{{ $field->type }}" @endif required>
                                    </div>
                                    <div class="form-group">
                                        <label for="location">{{ ucwords(str_replace("_"," ","location")) }}</label>
                                        <input type="text" class="form-control" id="location" name="location" @if($id != 'new') value="{{ $field->location }}" @endif required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="logo">{{ ucwords(str_replace("_"," ","logo")) }}</label>
                                        <input type="file" name="logo" id="logo" class="dropify" data-height="180" data-allowed-file-extensions="jpeg jpg png" @if(($id != 'new') and ($field->logo != "")) data-default-file="{{ asset('storage/logo/'.$field->logo) }}" @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Client</button>
                                <a href="{{ url('client') }}" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
