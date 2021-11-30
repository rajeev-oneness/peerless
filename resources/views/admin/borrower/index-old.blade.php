@extends('layouts.auth.master')

@section('title', 'Borrower list')

@section('content')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                            <a href="{{route('user.borrower.create')}}" class="btn btn-sm btn-primary"> <i class="fas fa-plus"></i> Create new borrower</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted">Displaying {{$data->firstItem()}} to {{$data->lastItem()}} out of {{$data->total()}} entries</p>
                        <table class="table table-sm table-bordered table-hover" id="borrowers-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Loan details</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)
                                <tr id="tr_{{$item->id}}">
                                    <td>{{$data->firstItem() + $index}}</td>
                                    <td>
                                        <div class="user-profile-holder">
                                            <div class="flex-shrink-0">
                                                <img src="{{asset($item->image_path)}}" alt="user-image-{{ $item->id }}">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="name">{{ucwords($item->name_prefix)}} {{$item->full_name}}</p>
                                                <p class="small text-muted">{{$item->occupation}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="small text-dark mb-1"><i class="fas fa-envelope mr-2"></i> {{$item->email}}</p>
                                        <p class="small text-dark mb-0">@php if(!empty($item->mobile)) { echo '<i class="fas fa-phone fa-rotate-90 mr-2"></i> '.$item->mobile; } else { echo '<i class="fas fa-phone fa-rotate-90 text-danger"></i>'; } @endphp</p>
                                    </td>
                                    <td>
                                        <p class="small text-muted mb-0" title="Street address">{{$item->street_address}}</p>
                                        <p class="small text-muted">
                                            <span title="City">{{$item->city}}</span>, 
                                            <span title="Pincode">{{$item->pincode}}</span>, 
                                            <span title="State">{{$item->state}}</span>
                                        </p>
                                    </td>
                                    <td>
                                        <div class="single-line">
                                            @if ($item->agreement_id == 0)
                                                <p class="small text-muted"> <em>No agreement yet</em> </p>
                                            @else
                                                <a href="{{route('user.borrower.agreement', $item->id)}}" class="badge badge-primary action-button" title="Setup loan application form">{{$item->agreementDetails->name}}</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="single-line">
                                            <a href="javascript: void(0)" class="badge badge-dark action-button" title="View" onclick="viewDeta1ls('{{route('user.borrower.show')}}', {{$item->id}})">View</a>

                                            <a href="{{route('user.borrower.edit', $item->id)}}" class="badge badge-dark action-button" title="Edit">Edit</a>

                                            <a href="javascript: void(0)" class="badge badge-dark action-button" title="Delete" onclick="confirm4lert('{{route('user.borrower.destroy')}}', {{$item->id}}, 'delete')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr><td class="text-center" colspan="100%"><em>No records found</em></td></tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="pagination-view">
                            {{$data->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        function viewDeta1ls(route, id) {
            $.ajax({
                url : route,
                method : 'post',
                data : {'_token' : '{{csrf_token()}}', id : id},
                success : function(result) {
                    let content = '';
                    if (result.error == false) {
                        let mobileShow = '<em class="text-muted">No data</em>';
                        if (result.data.mobile != null) {
                            mobileShow = result.data.mobile;
                        }

                        content += '<div class="w-100 user-profile-holder mb-3"><img src="'+result.data.image_path+'"></div>';
                        content += '<p class="text-muted small mb-1">Name</p><h6>'+result.data.name_prefix+' '+result.data.name+'</h6>';
                        content += '<p class="text-muted small mb-1">Email</p><h6>'+result.data.email+'</h6>';
                        content += '<p class="text-muted small mb-1">Phone number</p><h6>'+mobileShow+'</h6>';
                        content += '<p class="text-muted small mb-1">Address</p><h6>'+result.data.street_address+'</h6>';
                        content += '<h6>'+result.data.city+', '+result.data.pincode+', '+result.data.state+'</h6>';

                        let route = '{{route("user.borrower.details", 'id')}}';
                        route = route.replace('id',result.data.user_id);
                        $('#userDetails .modal-content').append('<div class="modal-footer"><a href="'+route+'" class="btn btn-sm btn-primary">View details <i class="fa fa-chevron-right"></i> </a></div>');
                    } else {
                        content += '<p class="text-muted small mb-1">No data found. Try again</p>';
                    }
                    $('#appendContent').html(content);
                    $('#userDetailsModalLabel').text('Borrower details');
                    $('#userDetails').modal('show');
                }
            });
        }
    </script>
@endsection