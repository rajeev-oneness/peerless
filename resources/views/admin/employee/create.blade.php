@extends('layouts.auth.master')

@section('title', 'Create new user')

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
                            <a href="{{route('user.employee.list')}}" class="btn btn-sm btn-primary"> <i class="fas fa-chevron-left"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                       </ul> --}}
                        <form class="form-horizontal" method="POST" action="{{ route('user.employee.store') }}" id="profile-form">
                        @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('name') {{'is-invalid'}} @enderror" id="name" name="name" placeholder="Full name" value="{{old('name')}}" autofocus>
                                    @error('name') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control @error('email') {{'is-invalid'}} @enderror" id="email" name="email" placeholder="Email ID" value="{{old('email')}}">
                                    @error('email') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label">Phone number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('mobile') {{'is-invalid'}} @enderror" id="mobile" name="mobile" placeholder="Phone number" value="{{old('mobile')}}">
                                    @error('mobile') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="parent_id" class="col-sm-2 col-form-label">Parent</label>
                                <div class="col-sm-10">
                                    <select name="parent_id" id="parent_id" class="form-control @error('parent_id') {{'is-invalid'}} @enderror">
                                        <option value="" hidden selected>Select reporting person</option>
                                        @foreach ($data->users as $item)
                                            <option value="{{$item->id}}">{{$item->name.' - '.$item->type->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_type" class="col-sm-2 col-form-label">Role <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select name="user_type" id="user_type" class="form-control @error('user_type') {{'is-invalid'}} @enderror">
                                        <option value="" hidden selected>Select role</option>
                                        @foreach ($data->user_type as $item)
                                            <option value="{{$item->id}}" {{(old('user_type') == $item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('user_type') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <div class="custom-control custom-switch mt-2 mb-2">
                                        <input type="checkbox" class="custom-control-input" id="sendPassword" name="sendPassword" onclick="mailSendChk()">
                                        <label class="custom-control-label" for="sendPassword">Send password via mail</label>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Type manual password" value="" st yle="display: none">
                                    @error('password') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
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
        function mailSendChk() {
            if ($('#sendPassword').is(':checked')) {
                $('#password').hide();
            } else {
                $('#password').show().focus();
            }
        }
    </script>
@endsection