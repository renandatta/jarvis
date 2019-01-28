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
                        <form action="{{ url('user_log/search') }}" method="post">
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
                                <div class="col-md-5">
                                    <select name="user_id" id="user_id" class="form-control select2">
                                        <option @if($user_id == 'all') selected @endif disabled>Select User</option>
                                        @foreach($user as $value)
                                            <option value="{{ $value->id }}">{{ $value->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
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
                    <div class="card-header">User Log</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="8%">#</th>
                                    <th>Data / Time</th>
                                    <th>Action</th>
                                    <th>Log</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{ (($data->currentPage()-1)*10)+($key+1) }}</td>
                                        <td class="text-nowrap">{{ $value->date.','.$value->time }}</td>
                                        <td>{{ $value->action }}</td>
                                        <td>{{ $value->log }}</td>
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