@extends('layouts.auth.master')

@section('title', 'Edit Estamp')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <a href="{{route('user.estamp.list')}}" class="btn btn-sm btn-primary"> <i class="fas fa-chevron-left"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.estamp.update',$stamp_details->id) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="unique_stamp_code" class="col-sm-2 col-form-label">Unique Stamp Code <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('unique_stamp_code') {{'is-invalid'}} @enderror" id="unique_stamp_code" name="unique_stamp_code" placeholder="Unique Stamp Code" value="{{$stamp_details->unique_stamp_code ?? old('unique_stamp_code')}}" autofocus>
                                    @error('unique_stamp_code') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="unique_stamp_code" class="col-sm-2 col-form-label">File <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control @error('file') {{'is-invalid'}} @enderror" id="file" name="file" placeholder="Unique stamp code" value="{{ old('file')}}" autofocus>
                                    @error('file') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>

    </script>
@endsection