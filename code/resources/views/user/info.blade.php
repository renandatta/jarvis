@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">@if($id == 'new') Add New User @else Edit User @endif</div>
                    <div class="card-body">
                        <form action="{{ url('user/save/'.$id) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="fullname">{{ ucwords(str_replace("_"," ","fullname")) }}</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" @if($id != 'new') value="{{ $field->fullname }}" @endif required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ ucwords(str_replace("_"," ","email")) }}</label>
                                <input type="email" class="form-control" id="email" name="email" @if($id != 'new') value="{{ $field->email }}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ ucwords(str_replace("_"," ","password")) }}</label>
                                <input type="password" class="form-control" id="password" name="password" @if($id == 'new') required @endif>
                                @if($id != 'new') <i>*) Leave empty if no changes</i> @endif
                            </div>
                            <div class="form-group">
                                <label for="user_level_id">{{ ucwords(str_replace("_"," ","user_level")) }}</label>
                                <select name="user_level_id" id="user_level_id" class="form-control select2">
                                    @foreach($user_level as $value)
                                        <option value="{{ $value->id }}" @if(($id != 'new') and ($field->user_level_id) == $value->id) selected @endif>{{ $value->user_level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save User</button>
                                <a href="{{ url('user') }}" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
