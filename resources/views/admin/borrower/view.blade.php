@extends('layouts.auth.master')

@section('title', 'View borrower details')

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

                            <a href="{{route('user.borrower.edit', $data->id)}}" class="btn btn-sm btn-success" title="Edit borrower"><i class="fas fa-edit"></i> Edit</a>

                            <a href="javascript: void(0)" class="btn btn-sm btn-danger" title="Delete borrower" onclick="confirm4lert('{{route('user.borrower.destroy')}}', {{$data->id}}, 'delete')"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="font-weight-bold mb-1">
                            <span>{{ucwords($data->name_prefix)}}</span> 
                            <span title="Name">{{$data->full_name}}</span>, 
                            <span title="Age" class="text-muted">{{date('Y') - date('Y', strtotime($data->date_of_birth))}}</span>
                            <span title="Gender" class="text-muted">({{ucwords($data->gender)}})</span>
                        </h6>
                        {{-- <h6 class="font-weight-bold mb-3 text-muted">{{ucwords($data->gender)}}</h6> --}}

                        <p class="text-muted small mb-0">Email</p>
                        <p class="text-dark small">{{$data->email}}</p>
                        <p class="text-muted small mb-0">Mobile</p>
                        <p class="text-dark small">{{$data->mobile}}</p>

                        <hr>

                        <p class="text-muted small mb-0">Occupation</p>
                        <p class="text-dark small">{{$data->occupation}}</p>
                        <p class="text-muted small mb-0">Date of birth</p>
                        <p class="text-dark small">{{$data->date_of_birth}}</p>
                        <p class="text-muted small mb-0">Marital status</p>
                        <p class="text-dark small mb-0">{{$data->marital_status}}</p>

                        <hr>

                        <p class="text-muted small mb-0">Street address2</p>
                        <p class="text-dark small">{{$data->street_address}}</p>
                        <p class="text-muted small mb-0">City</p>
                        <p class="text-dark small">{{$data->city}}</p>
                        <p class="text-muted small mb-0">Pincode</p>
                        <p class="text-dark small">{{$data->pincode}}</p>
                        <p class="text-muted small mb-0">State</p>
                        <p class="text-dark small mb-0">{{$data->state}}</p>
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