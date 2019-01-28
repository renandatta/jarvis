@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mt-3">
                    <div class="card-header">Project Information</div>
                    <div class="card-body">
                        <h6 class="mb-0">Name</h6>
                        <h5 class="mt-0">{{ $project->name }}</h5>
                        <hr class="mt-1 mb-3">
                        <h6 class="mb-0">Client</h6>
                        <h5 class="mt-0">{{ $project->client->name }}</h5>
                        <hr class="mt-1 mb-3">

                        <div class="text-center">
                            <a href="{{ url('project/info/'.$project->id) }}" class="btn btn-primary btn-sm">Edit Information</a>
                            <a href="{{ url('timeline/'.$project->id) }}" class="btn btn-primary btn-sm">Timeline</a>
                            <a href="{{ url('repository/'.$project->id) }}" class="btn btn-primary btn-sm">Repository</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mt-3">
                    <div class="card-header">Attachment</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <form action="{{ url('project/attachment/'.$project->id) }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <input type="file" name="attachment" id="attachment" class="dropify" data-height="100" data-allowed-file-extensions="dov docx xls xlsx pdf jpg jpeg png sql" required>
                                        </div>
                                        <div class="card-footer p-1">
                                            <button type="submit" class="btn btn-primary btn-block btn-sm">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @foreach($attachment as $key => $value)
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body p-1 text-center">
                                            @php
                                                $temp = explode(".",$value);
                                                $extension = $temp[count($temp)-1];
                                                $temp = explode(";",$value);
                                                $filename = $temp[1];
                                            @endphp
                                            <img src="{{ asset('assets/icon_file_type/'.$extension.'.png') }}" alt="" class="img-responsive">
                                            <p class="mb-0">{{ $filename }}</p>
                                        </div>
                                        <div class="card-footer p-1">
                                            <a class="btn btn-block btn-danger btn-sm" href="javascript:void(0)" onclick="document.getElementById('deleteAttachment{{ $key }}').submit();">Delete</a>
                                            <form action="{{ url('project/attachment/'.$project->id) }}" method="post" id="deleteAttachment{{ $key }}">
                                                <input type="hidden" name="index" value="{{ $key }}">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection