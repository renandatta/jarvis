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
                                        <label for="client_type_id">{{ ucwords(str_replace("_"," ","client_type")) }}</label>
                                        <select name="client_type_id" id="client_type_id" class="form-control select2">
                                            @foreach($client_type as $value)
                                                <option value="{{ $value->id }}" @if(($id != 'new') and ($field->client_type_id) == $value->id) selected @endif>{{ $value->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="location_id">{{ ucwords(str_replace("_"," ","location")) }}</label>
                                        <select name="location_id" id="location_id" class="form-control select2">
                                            @foreach($location as $value)
                                                <option value="{{ $value->id }}" @if(($id != 'new') and ($field->location_id) == $value->id) selected @endif>{{ $value->location }}</option>
                                            @endforeach
                                        </select>
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
