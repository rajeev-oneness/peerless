@extends('layouts.auth.master')

@section('title', 'Edit user')

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
                        <form class="form-horizontal" method="POST" action="{{ route('user.employee.update', $data->user->id) }}" id="profile-form">
                        @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('name') {{'is-invalid'}} @enderror" id="name" name="name" placeholder="Full name" value="{{old('name') ? old('name') : $data->user->name}}">
                                    @error('name') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control @error('email') {{'is-invalid'}} @enderror" id="email" name="email" placeholder="Email ID" value="{{$data->user->email}}" disabled>
                                    <p class="small text-muted mt-2 mb-0">Email id cannot be changed once registered</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label">Phone number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('mobile') {{'is-invalid'}} @enderror" id="mobile" name="mobile" placeholder="Phone number" value="{{old('mobile') ? old('mobile') : $data->user->mobile}}">
                                    @error('mobile') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="parent_id" class="col-sm-2 col-form-label">Parent</label>
                                <div class="col-sm-10">
                                    <select name="parent_id" id="parent_id" class="form-control @error('parent_id') {{'is-invalid'}} @enderror">
                                        <option value="" hidden selected>Select reporting person</option>
                                        @foreach ($data->users as $item)
                                            <option value="{{$item->id}}" {{($data->user->parent_id == $item->id) ? 'selected' : ''}}>{{$item->name.' - '.$item->type->name}}</option>
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
                                            <option value="{{$item->id}}"  {{($data->user->user_type == $item->id) ? 'selected' : ''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('user_type') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
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