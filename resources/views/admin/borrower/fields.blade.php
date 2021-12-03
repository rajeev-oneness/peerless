@extends('layouts.auth.master')

@section('title', 'Setup agreement fields')

@section('content')
    <section class="content">
        <link rel="stylesheet" href="{{ asset('admin/plugins/bs-stepper/css/bs-stepper.min.css') }}">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <a href="{{ route('user.borrower.list') }}" class="btn btn-sm btn-primary"> <i class="fas fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="font-weight-light text-dark">
                                        <span class="font-weight-normal" title="Borrower's name">
                                            {{ ucwords($data->name_prefix) }}
                                            {{ $data->full_name }}
                                        </span> -
                                        <span title="Agreement name">{{ $data->agreement_name }}</span>
                                    </h5>
                                </div>
                                <div class="col-md-4 text-right">
                                    @if ($data->agreementRfq > 0)
                                        <a href="{{ route('user.borrower.agreement.pdf.view', [$id, $data->agreement_id]) }}" class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> View PDF</a>

                                        <a href="{{ route('user.borrower.agreement.pdf.view', [$id, $data->agreement_id, 'status' => 'download']) }}" class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-download"></i> Download PDF</a>
                                    @endif
                                </div>

                                <div class="col-md-12 mt-3">
                                    <p class="small text-muted mb-0"><span class="text-danger">*</span> Please fill up the form first to view PDF</p>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">

                                    <input type="hidden" name="borrower_id" id="borrower_id" value="{{ request()->id }}">

                                    <div class="bs-stepper">
                                        <div class="bs-stepper-header" role="tablist">
                                            <div class="step" data-target="#information-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="information-part" id="information-part-trigger">
                                                    <span class="bs-stepper-circle"><i class="fas fa-user"></i></span>
                                                    <span class="bs-stepper-label">Borrower's information</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#document-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="document-part" id="document-part-trigger">
                                                    <span class="bs-stepper-circle"><i class="fas fa-file-import"></i></span>
                                                    <span class="bs-stepper-label">Documents</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#submit-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="submit-part" id="submit-part-trigger">
                                                    <span class="bs-stepper-circle"><i class="fas fa-save"></i></span>
                                                    <span class="bs-stepper-label">Submit</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-stepper-content">
                                            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                                @if (count($data->fields) > 0)
                                                    <form action="{{ route('user.borrower.agreement.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <table class="table table-sm table-bordered table-hover" id="agreementFieldsTable">
                                                            {{-- @foreach ($data->fields as $index => $item) --}}
                                                            @forelse ($data->parentFields as $index => $parent)
                                                            <tr>
                                                                <td colspan="3" class="field-heading">{{$parent->name}}</td>
                                                            </tr>
                                                            <tr>
                                                            </tr>
                                                            @foreach ($parent->childRelation as $index => $item)
                                                            <tr>
                                                                <td style="width: 50px">{{$index + 1}}</td>
                                                                <td class="fields_col-1">
                                                                    <label class="font-weight-bold">{!! $item->childField->name !!}
                                                                    {!! $item->childField->required == 1 ? '<span class="text-danger" title="This field is required">*</span>' : '' !!}</label>
                                                                </td>
                                                                <td class="fields_col-2">
                                                                    @php
                                                                        if ($data->agreementRfq > 0) {
                                                                            $formType = 'show';
                                                                        } else {
                                                                            $formType = 'create';
                                                                        }
                                                                    @endphp

                                                                    {!! form3lements($item->childField->id, $item->childField->name, $item->childField->inputType->name, $item->childField->value, $item->childField->key_name, 'required', $borrowerId = $id, $formType) !!}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @empty
                                                            <tr>
                                                                <td colspan="100%"><em>No records found</em></td>
                                                            </tr>
                                                            @endforelse

                                                            {{-- data submit / edit --}}
                                                            <tr>
                                                                <td colspan="3" style="position: sticky;bottom: 0;z-index: 99;background-color: #e9e9e9;">
                                                                    <div class="w-100 text-right">
                                                                        <input type="hidden" name="borrower_id" value="{{ $id }}">
                                                                        <input type="hidden" name="agreement_id" value="{{ $data->agreement_id }}">

                                                                        @if ($data->agreementRfq > 0)

                                                                        {{-- <button type="button" class="btn btn-sm btn-success" onclick="editAgreementFields()">Edit <i class="fas fa-edit"></i></button> --}}

                                                                        <button type="button" class="btn btn-sm btn-primary" onclick="stepper.next()">Go to Documents <i class="fas fa-chevron-right"></i></button>

                                                                        @else
                                                                        <button type="submit" class="btn btn-sm btn-primary">Submit data <i class="fas fa-upload"></i></button>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                @else
                                                    <div class="w-100">
                                                        <p><em>No fields found for this agreement</em></p>
                                                        <a href="{{ route('user.agreement.fields', $data->agreement_id) }}"
                                                            class="btn btn-sm btn-primary">Setup fields</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <div id="document-part" class="content" role="tabpanel" aria-labelledby="document-part-trigger">
                                                <div class="card border shadow-none rounded-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @forelse ($data->requiredDocuments as $index => $documentHead)
                                                                <div class="col-sm-12">
                                                                    <p class="text-dark font-weight-bold">
                                                                        {{ $index + 1 }} {{ $documentHead->name }}
                                                                    </p>
                                                                </div>

                                                                @foreach ($documentHead->siblingsDocuments as $childItem)
                                                                    <div class="col-sm-2">
                                                                        <div class="card">
                                                                            <div class="card-header p-2">{{ $childItem->name }}</div>
                                                                            <div class="card-body p-2">
                                                                                <div class="image__preview">
                                                                                    <img class="card-img-top img-fluid" src="{{ documentSrc($childItem->id, $id, 'image') }}" alt="Cover Image" id="image__preview{{ $childItem->id }}">
                                                                                </div>
                                                                                <div class="row mt-2">
                                                                                    <div class="col-12 text-center">
                                                                                        <form class="fileUploadForm"
                                                                                            enctype="multipart/form-data"
                                                                                            id="image_upload_form{{ $childItem->id }}">

                                                                                            <input type="file"
                                                                                                name="document"
                                                                                                id="file_{{ $childItem->id }}"
                                                                                                class="borrower-document-upload d-none"
                                                                                                onchange="docUpload(this, {{ $childItem->id }})">

                                                                                            <input type="hidden"
                                                                                                name="agreement_document_id"
                                                                                                id="agreement_document_id_{{ $childItem->id }}"
                                                                                                value="{{ $childItem->id }}">

                                                                                            {!! documentSrc($childItem->id, $id, 'action') !!}

                                                                                            {{-- <label for="file_{{ $childItem->id }}" class="btn btn-xs btn-primary" id="image__preview_label{{ $childItem->id }}">Browse <i class="fas fa-camera"></i></label> --}}

                                                                                            <button type="submit" class="btn btn-xs btn-success mb-2" id="image__upload_label{{ $childItem->id }}" style="display:none" onclick="docUpload({{ $childItem->id }})"> Upload <i class="fas fa-upload"></i></button>

                                                                                            <label class="btn btn-xs btn-primary mb-2" id="image_upload_status_{{ $childItem->id }}" style="display:none"></label>

                                                                                            <div
                                                                                                class="progress progress-sm">
                                                                                                <div class="progress-bar"
                                                                                                    id="progress_{{ $childItem->id }}"
                                                                                                    role="progressbar"
                                                                                                    style="width: 0%;display:none;"
                                                                                                    aria-valuenow="0"
                                                                                                    aria-valuemin="0"
                                                                                                    aria-valuemax="100">
                                                                                                </div>
                                                                                            </div>

                                                                                            <span title="Remove image"
                                                                                                class="remove_selected_file text-danger"
                                                                                                id="remove__image{{ $childItem->id }}"
                                                                                                style="display: none;"
                                                                                                onclick="clearimg({{ $childItem->id }})"><i class="fas fa-times"></i></span>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @empty
                                                                <div class="col-sm-12 text-center">
                                                                    <p class="text-muted"><em>No documents to upload</em></p>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                    <div class="card-footer" style="position: sticky;bottom: 0;z-index: 99;background-color: #e9e9e9;padding: 0.3rem;">
                                                        <div class="text-right">
                                                            <button class="btn btn-sm btn-primary" onclick="stepper.previous()"><i class="fas fa-chevron-left"></i> Back to borrower's form</button>
                                                            <button type="button" class="btn btn-sm btn-primary" onclick="stepper.next()">Go to Submit <i class="fas fa-chevron-right"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="submit-part" class="content" role="tabpanel" aria-labelledby="submit-part-trigger">
                                                <button class="btn btn-sm btn-primary" onclick="stepper.previous()"><i class="fas fa-chevron-left"></i> Back to Documents</button>
                                                {{-- <button type="submit" class="btn btn-sm btn-primary">Submit <i class="fas fa-save"></i></button> --}}
                                                <a href="{{route('user.borrower.list')}}" class="btn btn-sm btn-primary">Submit <i class="fas fa-save"></i></a>
                                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="{{ asset('admin/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>

    <script>
        // step by step document upload
        var stepper = new Stepper($('.bs-stepper')[0]);

        // document upload
        function docUpload(input, agreement_document_id) {
            // after selecting an image, show preview
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image__preview' + agreement_document_id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
                $('#image__preview_label' + agreement_document_id).hide();
                $('#image__upload_label' + agreement_document_id).show();
                $('#remove__image' + agreement_document_id).show();
            }

            $('#image_upload_form' + agreement_document_id).submit(function(event) {
                event.preventDefault();
                $('#image_upload_status_' + agreement_document_id).removeClass('btn-primary').removeClass('btn-success').removeClass('btn-danger');
                var form = $(this);
                $('#progress_' + agreement_document_id).css('width', '0').show();
                $(this).ajaxSubmit({
                    type: 'POST',
                    url: '{{ route('user.borrower.agreement.document.upload') }}',
                    // data: form.serialize(),
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'agreement_document_id': agreement_document_id,
                        'borrower_id': $('#borrower_id').val(),
                        'document': $('#file_' + agreement_document_id).val(),
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#progress_' + agreement_document_id).text(percentComplete + '%');
                                $('#progress_' + agreement_document_id).css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#remove__image' + agreement_document_id).prop('disabled', true).hide();
                        $('#image__upload_label' + agreement_document_id).prop('disabled', true).hide();
                        $('#image_upload_status_' + agreement_document_id).addClass('disabled').addClass('btn-primary mb-2').html('Uploading...').show();
                    },
                    success: function(data) {
                        // console.log("success");
                        // console.log(data);
                        $('#image_upload_form' + agreement_document_id).trigger("reset");
                        // var obj = $.parseJSON(data);
                        if (data.response_code == 200) {
                            $('#image_upload_status_' + agreement_document_id).hide().html('').removeClass('disabled').removeClass('btn-primary');
                            $('#image_upload_status_' + agreement_document_id).addClass('btn-success').html('Complete <i class="uil uil-check"></i>').show();
                            setTimeout(function() {
                                // $('#image_upload_status_'+agreement_document_id).css('visibility', 'hidden');
                                $('#progress_' + agreement_document_id).css('width', '0').hide();
                                $('#image_upload_status_' + agreement_document_id).hide();
                                $('#image__preview_label' + agreement_document_id).show();
                                $('#image__upload_label' + agreement_document_id).prop('disabled', false);
                            }, 3500);
                        } else {
                            $('#image_upload_status_' + agreement_document_id).hide().html('').removeClass('disabled').removeClass('btn-primary');
                            $('#image_upload_status_' + agreement_document_id).addClass('btn-danger').html(data.message).show();
                            setTimeout(function() {
                                // $('#image_upload_status_'+agreement_document_id).css('visibility', 'hidden');
                                $('#progress_' + agreement_document_id).css('width', '0').hide();
                                $('#image_upload_status_' + agreement_document_id).hide();
                                $('#image__preview_label' + agreement_document_id).show();
                                $('#image__upload_label' + agreement_document_id).prop('disabled', false);
                            }, 5000);
                        }
                    },
                    error: function(data) {
                        console.log("error");
                        console.log(data);
                    }
                });
            });
        }

        // clear image after browse, before upload
        function clearimg(count) {
            // $("#image_"+count).val('');
            $('#image__preview' + count).attr('src', '{{ asset('admin/static-required/blank.png') }}');
            // $('#image__preview_label'+count).removeClass('btn-success').html('Browse <i class="uil uil-camera-plus"></i>');
            $('#image__preview_label' + count).show();
            $('#image__upload_label' + count).hide();
            $('#remove__image' + count).hide();
        }

        // view document
        function viewUploadedDocument(id) {
            $.ajax({
                url : '{{route("user.borrower.agreement.document.show")}}',
                method : 'post',
                data : {'_token' : '{{csrf_token()}}', id : id},
                success : function(result) {
                    // console.log(result.message);
                    let content = '';
                    if (result.response_code == 200) {
                        content += '<p class="text-muted small mb-1">Borrower</p><h6>'+result.message.agreement_document_upload.borrower_details.name_prefix+' '+result.message.agreement_document_upload.borrower_details.full_name+'</h6>';

                        content += '<p class="text-muted small mb-2 mt-3">Agreement</p>';

                        content += '<div class="card"><div class="card-header p-2"><h3 class="card-title">'+result.message.agreement_document_upload.document_details.name+'</h3><div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button><a class="btn btn-tool" href="'+result.file+'" download><i class="fas fa-download"></i></a></div></div><div class="card-body p-0"><img src="'+result.file+'" class="w-100" alt="'+result.message.agreement_document_upload.document_details.name+'"></div></div>';

                        content += '<p class="text-muted small mb-2 mt-3">Verify</p>';
                        if (result.message.agreement_document_upload.verify == 0) {
                            content += '<div id="verifyDocBigger"><a href="javascript: void(0)" class="btn btn-sm btn-danger" onclick="verifyUploadedDocument('+result.message.agreement_document_upload.id+', '+result.message.agreement_document_upload.verify+')">Document is unverified. Tap here to verify</a></div>';
                        } else {
                            content += '<div id="verifyDocBigger"><a href="javascript: void(0)" class="btn btn-sm btn-success" onclick="verifyUploadedDocument('+result.message.agreement_document_upload.id+', '+result.message.agreement_document_upload.verify+')">Document is verified. Tap here to remove verification</a></div>';
                        }
                    } else {
                        content += '<p class="text-muted small mb-1">No data found. Try again</p>';
                    }
                    $('#appendContent').html(content);
                    $('#userDetailsModalLabel').text('Document details');
                    $('#userDetails').modal('show');
                }
            });
        }

        // verify document
        function verifyUploadedDocument(id, type) {
            let typeShow = '';
            if (type == 1) {
                typeShow = 'un-verify';
            } else {
                typeShow = 'verify';
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to '+typeShow+' the record',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f44336',
                cancelButtonColor: '#8b8787',
                customClass: {
                    confirmButton: 'box-shadow-danger',
                },
                confirmButtonText: 'Yes, '+typeShow+' it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : '{{route("user.borrower.agreement.document.verify")}}',
                        method : 'post',
                        data : {'_token' : '{{csrf_token()}}', id : id, type: type},
                        success : function(result) {
                            if (result.response_code == 200) {
                                if (result.updateStatusCode == 1) {
                                    $('#verifyDocBigger').html('<a href="javascript: void(0)" class="btn btn-sm btn-success" onclick="verifyUploadedDocument('+id+', 0)">Document is verified. Tap here to remove verification</a>');

                                    $('#verifyDocToggle'+id).removeClass('btn-danger').addClass('btn-success').html('<i class="fas fa-clipboard-check"></i>');
                                } else {
                                    $('#verifyDocBigger').html('<a href="javascript: void(0)" class="btn btn-sm btn-danger" onclick="verifyUploadedDocument('+id+', 1)">Document is unverified. Tap here to verify</a>');

                                    $('#verifyDocToggle'+id).removeClass('btn-success').addClass('btn-danger').html('<i class="fas fa-question-circle"></i>');
                                }
                            } else {
                                $('#verifyDocBigger').html('<a href="javascript: void(0)" class="btn btn-sm btn-success" onclick="verifyUploadedDocument('+id+')">Something happened. Try again</a>');
                            }
                            // $('#appendContent').html(content);
                            // $('#userDetailsModalLabel').text('Borrower details');
                            // $('#userDetails').modal('show');
                        }
                    });
                }
            });
        }

        // edit agreement fields
        function editAgreementFields() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to edit the agreement fields. All the disabled fields will be active",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, edit it!',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#agreementFieldsTable input, select, textarea').prop('disabled', false);
                }
            })
        }
    </script>
@endsection
