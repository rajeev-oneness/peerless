@extends('layouts.auth.master')

@section('title', 'Setup agreement fields')

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
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="font-weight-light text-dark">
                                    <span class="font-weight-normal" title="Borrower's name">
                                        {{ucwords($data->name_prefix)}} 
                                        {{$data->full_name}}
                                    </span> - 
                                    <span title="Agreement name">{{$data->agreement_name}}</span>
                                </h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{route('user.borrower.agreement.pdf.view', [$id, $data->agreement_id])}}" class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> View PDF</a>
                                <a href="{{route('user.borrower.agreement.pdf.download', [$id, $data->agreement_id])}}" class="btn btn-sm btn-danger download-agreement"><i class="fas fa-download"></i> Download PDF</a>
                            </div>

                            <div class="col-md-12 mt-3">
                                <p class="small text-muted mb-0"><span class="text-danger">*</span> Please fill up the form first to view PDF</p>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">

                                @if(count($data->fields) > 0)
                                    <form action="{{route('user.borrower.agreement.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <table class="table table-sm table-bordered table-hover">
                                            @foreach ($data->fields as $index => $item)
                                            <tr>
                                                <td class="fields_col-1">
                                                    <h6 class="font-weight-bold">{!!$item->fieldDetails->name!!} {!!($item->fieldDetails->required == 1 ? '<span class="text-danger" title="This field is required">*</span>' : '')!!}</h6>
                                                </td>
                                                <td class="fields_col-2">
                                                    {!!form3lements($item->fieldDetails->id, $item->fieldDetails->name, $item->fieldDetails->inputType->name, $item->fieldDetails->value, $item->fieldDetails->key_name, 100, 'required')!!}
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2" style="position: sticky;bottom: 0;z-index: 99;background-color: #fff;">
                                                    <div class="w-100 text-right">
                                                        <input type="hidden" name="borrower_id" value="{{$id}}">
                                                        <input type="hidden" name="agreement_id" value="{{$data->agreement_id}}">

                                                        <button type="submit" class="btn btn-sm btn-primary">Submit changes</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </table>
                                    </form>
                                @else
                                    <div class="w-100">
                                        <p><em>No fields found for this agreement</em></p>
                                        <a href="{{route('user.agreement.fields', $data->agreement_id)}}" class="btn btn-sm btn-primary">Setup fields</a>
                                    </div>
                                @endif
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

    </script>
@endsection