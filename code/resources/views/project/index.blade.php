@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(Session::has('message'))
                    @php
                        $message = Session::get('message');
                    @endphp
                    <div class="alert alert-{{ $message['type'] }}" role="alert">
                        {{ $message['content'] }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('project/search') }}" method="post">
                            {{ csrf_field() }}
                            @php
                                $keyword = "";
                                if($search != "all"){
                                    $search_part = explode(";",$search);
                                    $search_part1 = explode(",",$search_part[0]);
                                    $keyword = $search_part1[2];
                                }
                            @endphp
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="{{ url('project/info/new') }}" class="btn btn-block btn-primary">Add New</a>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="keyword" placeholder="Keyword ..." value="{{ $keyword }}">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-light btn-block" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">Project</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="8%">#</th>
                                    <th>Name</th>
                                    <th>Client</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{ (($data->currentPage()-1)*10)+($key+1) }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->client->name }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a href="javascript:void(0)" class="dropdown-toggle text-black-50" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ url('project/attachment/'.$value->id) }}">Attachment</a>
                                                    <a class="dropdown-item" href="{{ url('repository/'.$value->id) }}">Repository</a>
                                                    <a class="dropdown-item" href="{{ url('timeline/'.$value->id) }}">Timeline</a>
                                                    <hr class="mt-1 mb-1">
                                                    <a class="dropdown-item" href="{{ url('project/info/'.$value->id) }}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('hapusData{{ $value->id }}').submit();">Delete</a>
                                                    <form action="{{ url('project/delete/'.$value->id) }}" method="post" id="hapusData{{ $value->id }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            {{ $data->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection