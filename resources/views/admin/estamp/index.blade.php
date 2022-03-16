@extends('layouts.auth.master')

@section('title', 'Estamp Inventory')

@section('content')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            {{-- <a href="{{ route('user.field.create') }}" class="btn btn-sm btn-primary"> <i class="fas fa-plus"></i> Create</a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">10Rs</a>
                            </li>
                            <li class="nav-item" role="presentation">
                              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">50Rs</a>
                            </li>
                            <li class="nav-item" role="presentation">
                              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">100Rs</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h6 class="badge badge-primary">Available Stamp: {{ availableStamp(10)->count() }}</h6>
                                <form action="{{ route('user.estamp.store') }}" method="POST"  enctype="multipart/form-data" id="ten_rs_stamp_form">
                                    @csrf
                                    <input type="hidden" name="amount" value="10">
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Unique Stamp Code <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('unique_stamp_code') {{'is-invalid'}} @enderror" id="ten_rs_unique_stamp_code" name="unique_stamp_code" placeholder="Unique Stamp Code" value="{{old('unique_stamp_code')}}" autofocus>
                                            @error('unique_stamp_code') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="ten_rs_unique_stamp_code_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Front Page <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control @error('front_page') {{'is-invalid'}} @enderror" id="ten_rs_front_page" name="front_page" placeholder="Unique stamp code" value="{{old('front_page')}}" autofocus>
                                            @error('front_page') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="ten_rs_front_page_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Back Page <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control @error('back_page') {{'is-invalid'}} @enderror" id="ten_rs_back_page" name="back_page" placeholder="Unique stamp code" value="{{old('back_page')}}" autofocus>
                                            @error('back_page') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="ten_rs_back_page_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" name="ten_rs_stamp" id="ten_rs_stamp">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title font-weight-bold">All 10Rs Estamps</div>
                                    </div>    
                                    <div class="card-body">
                                        <table class="table table-sm table-bordered table-hover table-striped" id="showRoleTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Unique Stamp Code</th>
                                                    <th>Amount(Rs)</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (availableStamp(10)->count() > 0)
                                                    @foreach (availableStamp(10) as $key => $stamp)
                                                        
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $stamp->unique_stamp_code }}</td>
                                                                <td>{{ $stamp->amount }}</td>
                                                                <td class="text-right">
                                                                    <div class="single-line">
                                                                        <a href="javascript: void(0)" class="badge badge-dark action-button" title="View" onclick="viewDeta1ls('{{route('user.estamp.show')}}', {{$stamp->id}})">View</a>
                            
                                                                        <a href="{{route('user.estamp.edit', $stamp->id)}}" class="badge badge-dark action-button" title="Edit">Edit</a>
                                
                                                                        {{-- <a href="javascript: void(0)" class="badge badge-dark action-button" title="Delete" onclick="confirm4lert('{{route('user.agreement.destroy')}}', {{$item->id}}, 'delete')">Delete</a> --}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>No Data Found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h6 class="badge badge-primary">Available Stamp: {{ availableStamp(50)->count() }}</h6>
                                <form action="{{ route('user.estamp.store') }}" method="POST" enctype="multipart/form-data" id="fifty_rs_stamp_form">
                                    @csrf
                                    <input type="hidden" name="amount" value="50">
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Unique Stamp Code <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('unique_stamp_code') {{'is-invalid'}} @enderror" id="fifty_rs_unique_stamp_code" name="unique_stamp_code" placeholder="Unique Stamp Code" value="{{old('unique_stamp_code')}}" autofocus>
                                            @error('unique_stamp_code') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="fifty_rs_unique_stamp_code_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Front Page <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control @error('front_page') {{'is-invalid'}} @enderror" id="fifty_rs_front_page" name="front_page" placeholder="Unique stamp code" value="{{old('front_page')}}" autofocus>
                                            @error('front_page') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="fifty_rs_front_page_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Back Page <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control @error('back_page') {{'is-invalid'}} @enderror" id="fifty_rs_back_page" name="back_page" placeholder="Unique stamp code" value="{{old('back_page')}}" autofocus>
                                            @error('back_page') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="fifty_rs_back_page_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" id="fifty_rs_stamp">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title font-weight-bold">All 50Rs Estamps</div>
                                    </div>    
                                    <div class="card-body">
                                        <table class="table table-sm table-bordered table-hover table-striped" id="showRoleTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Unique Stamp Code</th>
                                                    <th>Amount(Rs)</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (availableStamp(50)->count() > 0)
                                                    @foreach (availableStamp(50) as $key => $stamp)
                                                        
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $stamp->unique_stamp_code }}</td>
                                                            <td>{{ $stamp->amount }}</td>
                                                            <td class="text-right">
                                                                <div class="single-line">
                                                                    <a href="javascript: void(0)" class="badge badge-dark action-button" title="View" onclick="viewDeta1ls('{{route('user.estamp.show')}}', {{$stamp->id}})">View</a>
                        
                                                                    <a href="{{route('user.estamp.edit', $stamp->id)}}" class="badge badge-dark action-button" title="Edit">Edit</a>
                            
                                                                    {{-- <a href="javascript: void(0)" class="badge badge-dark action-button" title="Delete" onclick="confirm4lert('{{route('user.agreement.destroy')}}', {{$item->id}}, 'delete')">Delete</a> --}}
                                                                </div>
                                                            </td>
                                                        </tr> 
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>No Date Found</td>
                                                    </tr>
                                                 @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <h6 class="badge badge-primary">Available Stamp: {{ availableStamp(100)->count() }}</h6>
                                <form action="{{ route('user.estamp.store') }}" method="POST" enctype="multipart/form-data" id="hundred_rs_stamp_form">
                                    @csrf
                                    <input type="hidden" name="amount" value="100">
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Unique Stamp Code <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('unique_stamp_code') {{'is-invalid'}} @enderror" id="hundred_rs_unique_stamp_code" name="unique_stamp_code" placeholder="Unique Stamp Code" value="{{old('unique_stamp_code')}}" autofocus>
                                            @error('unique_stamp_code') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="hundred_rs_unique_stamp_code_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Front Page <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control @error('front_page') {{'is-invalid'}} @enderror" id="hundred_rs_front_page" name="front_page" placeholder="Unique stamp code" value="{{old('front_page')}}" autofocus>
                                            @error('front_page') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="hundred_rs_front_page_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="unique_stamp_code" class="col-sm-2 col-form-label">Back Page <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control @error('back_page') {{'is-invalid'}} @enderror" id="hundred_rs_back_page" name="back_page" placeholder="Unique stamp code" value="{{old('back_page')}}" autofocus>
                                            @error('back_page') <p class="small mb-0 text-danger">{{$message}}</p> @enderror
                                            <p class="small mb-0 text-danger" id="hundred_rs_back_page_err">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" id="hundred_rs_stamp">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title font-weight-bold">All 100Rs Estamps</div>
                                    </div>    
                                    <div class="card-body">
                                        <table class="table table-sm table-bordered table-hover table-striped" id="showRoleTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Unique Stamp Code</th>
                                                    <th>Amount(Rs)</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (availableStamp(100) as $key => $stamp)
                                                    @if (availableStamp(100)->count() > 0)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $stamp->unique_stamp_code }}</td>
                                                            <td>{{ $stamp->amount }}</td>
                                                            <td class="text-right">
                                                                <div class="single-line">
                                                                    <a href="javascript: void(0)" class="badge badge-dark action-button" title="View" onclick="viewDeta1ls('{{route('user.estamp.show')}}', {{$stamp->id}})">View</a>
                        
                                                                    <a href="{{route('user.estamp.edit', $stamp->id)}}" class="badge badge-dark action-button" title="Edit">Edit</a>
                            
                                                                    {{-- <a href="javascript: void(0)" class="badge badge-dark action-button" title="Delete" onclick="confirm4lert('{{route('user.agreement.destroy')}}', {{$item->id}}, 'delete')">Delete</a> --}}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>No Date Found</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
    <script>
        /*
        * For 10 Rs Stamp
        */
        $('#ten_rs_stamp').on('click',function(){
            var errorFlagOne = 0;
            event.preventDefault();
            var ten_rs_unique_stamp_code = $('#ten_rs_unique_stamp_code').val();
            var ten_rs_back_page = $('#ten_rs_back_page').val();
            var ten_rs_front_page = $('#ten_rs_front_page').val();
            if (ten_rs_unique_stamp_code == '') {
                $('#ten_rs_unique_stamp_code_err').text('This field is required');
                errorFlagOne = 1;
            }
            if (ten_rs_back_page == '') {
                $('#ten_rs_back_page_err').text('This field is required');
                errorFlagOne = 1;
            }
            if (ten_rs_front_page == '') {
                $('#ten_rs_front_page_err').text('This field is required');
                errorFlagOne = 1;
            }

            var allowedImageExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
            if (!allowedImageExtensions.exec(ten_rs_back_page) && ten_rs_back_page != '') {
                $('#ten_rs_back_page_err').html(
                    'Please upload file having jpg,jpeg,png and pdf extensions').fadeIn(100);
                errorFlagOne = 1;
            }
            if (!allowedImageExtensions.exec(ten_rs_front_page) && ten_rs_front_page != '') {
                $('#ten_rs_front_page_err').html(
                    'Please upload file having jpg,jpeg,png and pdf extensions').fadeIn(100);
                errorFlagOne = 1;
            }

            if (errorFlagOne == 1) {
                return false;
            } else {
                $("#ten_rs_stamp_form").submit();
            }
        });

        /*
        *For 50 Rs Stamp
        */
        $('#fifty_rs_stamp').on('click',function(){
            var errorFlagOne = 0;
            event.preventDefault();
            var fifty_rs_unique_stamp_code = $('#fifty_rs_unique_stamp_code').val();
            var fifty_rs_back_page = $('#fifty_rs_back_page').val();
            var fifty_rs_front_page = $('#fifty_rs_front_page').val();
            if (fifty_rs_unique_stamp_code == '') {
                $('#fifty_rs_unique_stamp_code_err').text('This field is required');
                errorFlagOne = 1;
            }
            if (fifty_rs_back_page == '') {
                $('#fifty_rs_back_page_err').text('This field is required');
                errorFlagOne = 1;
            }
            if (fifty_rs_front_page == '') {
                $('#fifty_rs_front_page_err').text('This field is required');
                errorFlagOne = 1;
            }

            var allowedImageExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
            if (!allowedImageExtensions.exec(fifty_rs_back_page) && fifty_rs_back_page != '') {
                $('#fifty_rs_back_page_err').html(
                    'Please upload file having jpg,jpeg,png and pdf extensions').fadeIn(100);
                errorFlagOne = 1;
            }
            if (!allowedImageExtensions.exec(fifty_rs_front_page) && fifty_rs_front_page != '') {
                $('#fifty_rs_front_page_err').html(
                    'Please upload file having jpg,jpeg,png and pdf extensions').fadeIn(100);
                errorFlagOne = 1;
            }

            if (errorFlagOne == 1) {
                return false;
            } else {
                $("#fifty_rs_stamp_form").submit();
            }
        });

        /*
        *For 100 Rs Stamp
        */
        $('#hundred_rs_stamp').on('click',function(){
            var errorFlagOne = 0;
            event.preventDefault();
            var hundred_rs_unique_stamp_code = $('#hundred_rs_unique_stamp_code').val();
            var hundred_rs_back_page = $('#hundred_rs_back_page').val();
            var hundred_rs_front_page = $('#hundred_rs_front_page').val();
            if (hundred_rs_unique_stamp_code == '') {
                $('#hundred_rs_unique_stamp_code_err').text('This field is required');
                errorFlagOne = 1;
            }
            if (hundred_rs_back_page == '') {
                $('#hundred_rs_back_page_err').text('This field is required');
                errorFlagOne = 1;
            }
            if (hundred_rs_front_page == '') {
                $('#hundred_rs_front_page_err').text('This field is required');
                errorFlagOne = 1;
            }

            var allowedImageExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
            if (!allowedImageExtensions.exec(hundred_rs_back_page) && hundred_rs_back_page != '') {
                $('#hundred_rs_back_page_err').html(
                    'Please upload file having jpg,jpeg,png and pdf extensions').fadeIn(100);
                errorFlagOne = 1;
            }
            if (!allowedImageExtensions.exec(hundred_rs_front_page) && hundred_rs_front_page != '') {
                $('#hundred_rs_front_page_err').html(
                    'Please upload file having jpg,jpeg,png and pdf extensions').fadeIn(100);
                errorFlagOne = 1;
            }

            if (errorFlagOne == 1) {
                return false;
            } else {
                $("#hundred_rs_stamp_form").submit();
            }
        });

        $(document).ready(function(){
            activaTab('home');
        });

        function activaTab(tab){
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        };

        function viewDeta1ls(route, id) {
            $.ajax({
                url : route,
                method : 'post',
                data : {'_token' : '{{csrf_token()}}', id : id},
                success : function(result) {
                    front_file_extension = result.data.front_file_path.split(".")[1];
                    back_file_extension = result.data.back_file_path.split(".")[1];
                    let content = '';
                    if (result.error == false) {

                        content += '<p class="text-muted small mb-0">Unique Stamp Code</p>';
                        content += '<p class="text-dark small mb-3">'+result.data.unique_stamp_code+'</p>';
                        content += '<p class="text-muted small mb-0">Amount(Rs)</p>';
                        content += '<p class="text-dark small">'+result.data.amount+'</p>';

                        content += '<div class="row">';
                        content += '<div class="col-md-6">';
                        if (front_file_extension === 'jpg' || front_file_extension === 'jpeg' || front_file_extension === 'png'){
                            content += '<p class="text-muted small mb-0">Front Page</p>';
                            content += `<div class="bl_img">
                                <img src="{{ asset('${result.data.front_file_path}') }}" alt="" class="img-fluid mx-auto">
                            </div>`;
                        }else{
                            content += '<p class="text-muted small mb-0">Front Page</p>';
                            content += ` <a href="{{ asset('${result.data.front_file_path}') }}" target="_blank"
                                    class="img-fluid mx-auto w-100">View file
                                    <span
                                        title="Update on"></span>
                                    <i class="fas fa-arrow-right"></i></a>`;
                        }
                        content += '</div>';
                        content += '<div class="col-md-6">';
                        if (back_file_extension === 'jpg' || back_file_extension === 'jpeg' || back_file_extension === 'png'){
                            content += '<p class="text-muted small mb-0">Back Page</p>';
                            content += `<div class="bl_img">
                                <img src="{{ asset('${result.data.back_file_path}') }}" alt="" class="img-fluid mx-auto">
                            </div>`;
                        }else{
                            content += '<p class="text-muted small mb-0">Back Page</p>';
                            content += ` <a href="{{ asset('${result.data.back_file_path}') }}" target="_blank"
                                    class="img-fluid mx-auto w-100">View file
                                    <span
                                        title="Update on"></span>
                                    <i class="fas fa-arrow-right"></i></a>`;
                        }
                        content += '</div>';
                        content += '</div>'

                    } else {
                        content += '<p class="text-muted small mb-1">No data found. Try again</p>';
                    }
                    $('#appendContent').html(content);
                    $('#userDetailsModalLabel').text('Estamp details');
                    $('#userDetails').modal('show');
                }
            });
        }
    </script>
@endsection

