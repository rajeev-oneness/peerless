@extends('layouts.auth.master')

@section('title', 'Field management')

@section('content')
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
                            <a href="{{route('user.field.create')}}" class="btn btn-sm btn-primary"> <i class="fas fa-plus"></i> Create</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-hover" id="showRoleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)
                                <tr id="tr_{{$item->id}}">
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <h6 class="font-weight-bold single-line">{{$item->name}} {!!($item->required == 1 ? '<span class="text-danger" title="This field is required">*</span>' : '')!!}</h6>
                                    </td>
                                    <td>
                                        {!!form3lements($item->name, $item->inputType->name, $item->value, $item->key_name)!!}
                                    </td>
                                    <td class="text-right">
                                        <div class="single-line">
                                            <a href="{{route('user.field.edit', $item->id)}}" class="badge badge-dark action-button" title="Edit">Edit</a>
    
                                            <a href="javascript: viod(0)" class="badge badge-dark action-button" title="Delete" onclick="confirm4lert('{{route('user.field.destroy')}}', {{$item->id}}, 'delete')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr><td colspan="100%"><em>No records found</em></td></tr>
                                @endforelse
                            </tbody>
                        </table>
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