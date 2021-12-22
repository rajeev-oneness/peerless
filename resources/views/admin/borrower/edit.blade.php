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
                                <a href="{{ route('user.borrower.list') }}" class="btn btn-sm btn-primary"> <i
                                        class="fas fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" method="POST"
                                action="{{ route('user.borrower.update', $data->user->id) }}" id="profile-form">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-1">
                                        <select class="form-control px-0" id="name_prefix" name="name_prefix">
                                            <option value="" hidden selected>Select Prefix</option>
                                            @foreach ($APP_data->namePrefix as $item)
                                                <option value="{{ $item }}"
                                                    {{ $data->user->name_prefix == $item ? 'selected' : '' }}>
                                                    {{ ucwords($item) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text"
                                            class="form-control @error('first_name') {{ 'is-invalid' }} @enderror"
                                            id="first_name" name="first_name" placeholder="Full name"
                                            value="{{ old('first_name') ? old('first_name') : $data->user->first_name }}"
                                            autofocus>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text"
                                            class="form-control @error('middle_name') {{ 'is-invalid' }} @enderror"
                                            id="middle_name" name="middle_name" placeholder="Full name"
                                            value="{{ old('middle_name') ? old('middle_name') : $data->user->middle_name }}"
                                            autofocus>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text"
                                            class="form-control @error('last_name') {{ 'is-invalid' }} @enderror"
                                            id="last_name" name="last_name" placeholder="Full name"
                                            value="{{ old('last_name') ? old('last_name') : $data->user->last_name }}"
                                            autofocus>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 offset-sm-2">
                                        @error('name_prefix') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('full_name') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-sm-2 col-form-label">Gender <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="" hidden selected>Select Gender</option>
                                            @foreach ($APP_data->genderList as $item)
                                                <option value="{{ $item }}"
                                                    {{ $data->user->gender == $item ? 'selected' : '' }}>
                                                    {{ ucwords($item) }}</option>
                                            @endforeach
                                        </select>
                                        @error('gender') <p class="small mb-0 text-danger">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="date_of_birth" class="col-sm-2 col-form-label">Date of birth <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        @php
                                            $date_of_birth = date('Y-m-d', strtotime($data->user->date_of_birth));
                                        @endphp
                                        <input type="date"
                                            class="form-control @error('date_of_birth') {{ 'is-invalid' }} @enderror"
                                            id="date_of_birth" name="date_of_birth" placeholder="Date of birth"
                                            value="{{ old('date_of_birth') ? old('date_of_birth') : $date_of_birth }}">
                                        @error('date_of_birth') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="email"
                                            class="form-control @error('email') {{ 'is-invalid' }} @enderror" id="email"
                                            name="email" placeholder="Email ID"
                                            value="{{ old('email') ? old('email') : $data->user->email }}">
                                        @error('email') <p class="small mb-0 text-danger">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-2 col-form-label">Phone number <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('mobile') {{ 'is-invalid' }} @enderror"
                                            id="mobile" name="mobile" placeholder="Phone number"
                                            value="{{ old('mobile') ? old('mobile') : $data->user->mobile }}">
                                        @error('mobile') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pan_card_number" class="col-sm-2 col-form-label">PAN card number <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('pan_card_number') {{ 'is-invalid' }} @enderror"
                                            id="pan_card_number" name="pan_card_number" placeholder="Pan card number"
                                            value="{{ old('pan_card_number') ? old('pan_card_number') : $data->user->pan_card_number }}">
                                        @error('pan_card_number') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="occupation" class="col-sm-2 col-form-label">Occupation <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('occupation') {{ 'is-invalid' }} @enderror"
                                            id="occupation" name="occupation" placeholder="Occupation"
                                            value="{{ old('occupation') ? old('occupation') : $data->user->occupation }}">
                                        @error('occupation') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="marital_status" class="col-sm-2 col-form-label">Marital status <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="marital_status" name="marital_status">
                                            <option value="" hidden selected>Select Marital status</option>
                                            @foreach ($APP_data->maritalStatus as $item)
                                                <option value="{{ $item }}"
                                                    {{ $data->user->marital_status == $item ? 'selected' : '' }}>
                                                    {{ ucwords($item) }}</option>
                                            @endforeach
                                        </select>
                                        @error('marital_status') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="street_address" class="col-sm-2 col-form-label">Address <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea
                                            class="form-control @error('street_address') {{ 'is-invalid' }} @enderror"
                                            id="street_address" name="street_address"
                                            placeholder="Street address">{{ old('street_address') ? old('street_address') : $data->user->street_address }}</textarea>
                                        @error('street_address') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-sm-10 offset-sm-2 mt-2">
                                        <input type="text"
                                            class="form-control @error('city') {{ 'is-invalid' }} @enderror" id="city"
                                            name="city" placeholder="City"
                                            value="{{ old('city') ? old('city') : $data->user->city }}">

                                        @error('city') <p class="small mb-0 text-danger">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="col-sm-10 offset-sm-2 mt-2">
                                        <input type="text"
                                            class="form-control @error('pincode') {{ 'is-invalid' }} @enderror"
                                            id="pincode" name="pincode" placeholder="Pincode"
                                            value="{{ old('pincode') ? old('pincode') : $data->user->pincode }}">

                                        @error('pincode') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-sm-10 offset-sm-2 mt-2">
                                        <input type="text"
                                            class="form-control @error('state') {{ 'is-invalid' }} @enderror" id="state"
                                            name="state" placeholder="State"
                                            value="{{ old('state') ? old('state') : $data->user->state }}">

                                        @error('state') <p class="small mb-0 text-danger">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="agreement_id" class="col-sm-2 col-form-label">Type of loan</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="agreement_id" name="agreement_id">
                                            <option value="" hidden selected>Select Type of loan</option>
                                            @foreach ($data->agreement as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('agreement_id') ? (old('agreement_id') == $item->id ? 'selected' : '') : ($data->user->agreement_id == $item->id ? 'selected' : '') }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('agreement_id') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <label for="Customer_Type" class="col-sm-2 col-form-label">Customer Type</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Customer_Type') {{ 'is-invalid' }} @enderror"
                                            id="Customer_Type" name="Customer_Type" placeholder="Customer_Type"
                                            value="{{ old('Customer_Type') ? old('Customer_Type') : $data->user->Customer_Type }}">
                                        @error('Customer_Type') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Resident_Status" class="col-sm-2 col-form-label">Resident Status </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Resident_Status') {{ 'is-invalid' }} @enderror"
                                            id="Resident_Status" name="Resident_Status" placeholder="Resident_Status"
                                            value="{{ old('Resident_Status') ? old('Resident_Status') : $data->user->Resident_Status }}">
                                        @error('Resident_Status') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Aadhar_Number" class="col-sm-2 col-form-label">Aadhar Number </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Aadhar_Number') {{ 'is-invalid' }} @enderror"
                                            id="Aadhar_Number" name="Aadhar_Number" placeholder="Aadhar Number"
                                            value="{{ old('Aadhar_Number') ? old('Aadhar_Number') : $data->user->Aadhar_Number }}">
                                        @error('Aadhar_Number') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Main_Constitution" class="col-sm-2 col-form-label">Main Constitution
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Main_Constitution') {{ 'is-invalid' }} @enderror"
                                            id="Main_Constitution" name="Main_Constitution" placeholder="Main Constitution"
                                            value="{{ old('Main_Constitution') ? old('Main_Constitution') : $data->user->Main_Constitution }}">
                                        @error('Main_Constitution') <p class="small mb-0 text-danger">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Sub_Constitution" class="col-sm-2 col-form-label">Sub Constitution </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Sub_Constitution') {{ 'is-invalid' }} @enderror"
                                            id="Sub_Constitution" name="Sub_Constitution" placeholder="Sub Constitution"
                                            value="{{ old('Sub_Constitution') ? old('Sub_Constitution') : $data->user->Sub_Constitution }}">
                                        @error('Sub_Constitution') <p class="small mb-0 text-danger">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="KYC_Date" class="col-sm-2 col-form-label">KYC Date </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('KYC_Date') {{ 'is-invalid' }} @enderror"
                                            id="KYC_Date" name="KYC_Date" placeholder="KYC Date"
                                            value="{{ old('KYC_Date') ? old('KYC_Date') : $data->user->KYC_Date }}">
                                        @error('KYC_Date') <p class="small mb-0 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Re_KYC_Due_Date" class="col-sm-2 col-form-label">Re KYC Due Date </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Re_KYC_Due_Date') {{ 'is-invalid' }} @enderror"
                                            id="Re_KYC_Due_Date" name="Re_KYC_Due_Date" placeholder="Re KYC Due Date"
                                            value="{{ old('Re_KYC_Due_Date') ? old('Re_KYC_Due_Date') : $data->user->Re_KYC_Due_Date }}">
                                        @error('Re_KYC_Due_Date') <p class="small mb-0 text-danger">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Minor" class="col-sm-2 col-form-label">Minor </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Minor') {{ 'is-invalid' }} @enderror" id="Minor"
                                            name="Minor" placeholder="Minor"
                                            value="{{ old('Minor') ? old('Minor') : $data->user->Minor }}">
                                        @error('Minor') <p class="small mb-0 text-danger">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Customer Category" class="col-sm-2 col-form-label">Customer Category
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Customer_Category') {{ 'is-invalid' }} @enderror"
                                            id="Customer_Category" name="Customer_Category" placeholder="Customer Category"
                                            value="{{ old('Customer_Category') ? old('Customer_Category') : $data->user->Customer_Category }}">
                                        @error('Customer_Category') <p class="small mb-0 text-danger">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Alternate_Mobile_No" class="col-sm-2 col-form-label">Alternate Mobile No
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('Alternate_Mobile_No') {{ 'is-invalid' }} @enderror"
                                            id="Alternate_Mobile_No" name="Alternate_Mobile_No"
                                            placeholder="Alternate_Mobile_No"
                                            value="{{ old('Alternate Mobile No') ? old('Alternate_Mobile_No') : $data->user->Alternate_Mobile_No }}">
                                        @error('Alternate_Mobile_No') <p class="small mb-0 text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
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
