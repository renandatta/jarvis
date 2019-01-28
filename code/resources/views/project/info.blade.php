@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">@if($id == 'new') Add New Project @else Edit Project @endif</div>
                    <div class="card-body">
                        <form action="{{ url('project/save/'.$id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="client_id">{{ ucwords(str_replace("_"," ","client")) }}</label>
                                        <select name="client_id" id="client_id" class="form-control select2">
                                            @foreach($client as $value)
                                                <option value="{{ $value->id }}" @if(($id != 'new') and ($field->client_id) == $value->id) selected @endif>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ ucwords(str_replace("_"," ","name")) }}</label>
                                        <input type="text" class="form-control" id="name" name="name" @if($id != 'new') value="{{ $field->name }}" @endif required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ ucwords(str_replace("_"," ","description")) }}</label>
                                        <textarea name="description" id="description" class="summernote">@if($id != 'new') {!! $field->content !!} @endif</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="image">{{ ucwords(str_replace("_"," ","image")) }}</label>
                                        <input type="file" name="image" id="image" class="dropify" data-height="200" data-allowed-file-extensions="jpeg jpg png" @if(($id != 'new') and ($field->image != "")) data-default-file="{{ asset('storage/project/'.$field->image) }}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="banner">{{ ucwords(str_replace("_"," ","banner")) }}</label>
                                        <input type="file" name="banner" id="banner" class="dropify" data-height="150" data-allowed-file-extensions="jpeg jpg png" @if(($id != 'new') and ($field->banner != "")) data-default-file="{{ asset('storage/project/'.$field->banner) }}" @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Project</button>
                                <a href="{{ url('project') }}" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
