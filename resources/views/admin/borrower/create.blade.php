@extends('layouts.auth.master')

@section('title', 'Create new borrower')

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
                            <a href="{{route('user.borrower.list')}}" class="btn btn-sm btn-primary"> <i class="fas fa-chevron-left"></i> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('user.borrower.store') }}" id="profile-form">
                        @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="name_prefix" name="name_prefix">
                                        <option value="" hidden selected>Select Prefix</option>
                                        @foreach ($APP_data->namePrefix as $item)
                                            <option value="{{$item}}" {{old('name_prefix') ? (old('name_prefix') == $item ? 'selected' : '' ) : ''}}>{{ucwords($item)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('full_name') {{'is-invalid'}} @enderror" id="full_name" name="full_name" placeholder="Full name" value="{{old('full_name')}}" autofocus>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 offset-sm-2">
                                    @error('name_prefix') <p class="small mb-0 text-danger">{{$message}}</p>@enderror
                                    @error('full_name') <p class="small mb-0 text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender" class="col-sm-2 col-form-label">Gender <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="" hidden selected>Select Gender</option>
                                        @foreach ($APP_data->genderList as $item)
                                            <option value="{{$item}}" {{old('gender') ? (old('gender') == $item ? 'selected' : '' ) : ''}}>{{ucwords($item)}}</option>
                                        @endforeach
                                    </select>
                                    @error('gender') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="date_of_birth" class="col-sm-2 col-form-label">Date of birth <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control @error('date_of_birth') {{'is-invalid'}} @enderror" id="date_of_birth" name="date_of_birth" placeholder="Date of birth" value="{{old('date_of_birth')}}">
                                    @error('date_of_birth') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
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
                                <label for="mobile" class="col-sm-2 col-form-label">Phone number <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('mobile') {{'is-invalid'}} @enderror" id="mobile" name="mobile" placeholder="Phone number" value="{{old('mobile')}}">
                                    @error('mobile') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="occupation" class="col-sm-2 col-form-label">Occupation <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('occupation') {{'is-invalid'}} @enderror" id="occupation" name="occupation" placeholder="Occupation" value="{{old('occupation')}}">
                                    @error('occupation') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="marital_status" class="col-sm-2 col-form-label">Marital status <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="marital_status" name="marital_status">
                                        <option value="" hidden selected>Select Marital status</option>
                                        @foreach ($APP_data->maritalStatus as $item)
                                            <option value="{{$item}}" {{old('marital_status') ? (old('marital_status') == $item ? 'selected' : '' ) : ''}}>{{ucwords($item)}}</option>
                                        @endforeach
                                    </select>
                                    @error('marital_status') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street_address" class="col-sm-2 col-form-label">Address <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control @error('street_address') {{'is-invalid'}} @enderror" id="street_address" name="street_address" placeholder="Street address">{{old('street_address')}}</textarea>
                                    @error('street_address') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>

                                <div class="col-sm-10 offset-sm-2 mt-2">
                                    <input type="text" class="form-control @error('city') {{'is-invalid'}} @enderror" id="city" name="city" placeholder="City" value="{{old('city')}}">

                                    @error('city') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>

                                <div class="col-sm-10 offset-sm-2 mt-2">
                                    <input type="text" class="form-control @error('pincode') {{'is-invalid'}} @enderror" id="pincode" name="pincode" placeholder="Pincode" value="{{old('pincode')}}">

                                    @error('pincode') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                </div>

                                <div class="col-sm-10 offset-sm-2 mt-2">
                                    <input type="text" class="form-control @error('state') {{'is-invalid'}} @enderror" id="state" name="state" placeholder="State" value="{{old('state')}}">

                                    @error('state') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
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