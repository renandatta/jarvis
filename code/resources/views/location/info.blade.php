@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">@if($id == 'new') Add New Location @else Edit Location @endif</div>
                    <div class="card-body">
                        <form action="{{ url('location/save/'.$id) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="location">{{ ucwords(str_replace("_"," ","location")) }}</label>
                                <input type="text" class="form-control" id="location" name="location" @if($id != 'new') value="{{ $field->location }}" @endif required autofocus>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Location</button>
                                <a href="{{ url('location') }}" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
