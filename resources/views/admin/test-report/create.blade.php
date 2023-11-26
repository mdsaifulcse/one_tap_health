@extends('admin.layout.app')
@section('title')
   Upload Test Report | Dashboard
@endsection

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    @endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Upload Test Report </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.test-reports.index')}}" class="btn btn-info btn-sm" title="Test List here"><i class="icofont icofont-list"></i> Test Report List</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
                    <!-- Form -->
                        {!! Form::open(array('route' => 'admin.test-reports.store','class'=>'report-form','files'=>true)) !!}
                        <input type="hidden" name="test_order_id" value="{{$testOrder->id}}" id="testOrderId" />

                    <div class="card">
                        <div class="card-header">
                            <h5> Upload Test Report </h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="">

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            Order No.: <b>#{{$testOrder->order_no}}</b> <br>
                                            Test Date.: {{date('d-M-Y h:i A',strtotime($testOrder->test_date))}} <br>
                                            Patient Name: <b>{{$testOrder->patient->name}}</b> <br>
                                            Age: <b>{{$testOrder->patient->age}}</b><br>
                                            Patient Mobile: {{$testOrder->patient->mobile}} <br>
                                        </div>
                                        <div class="col-md-6">
                                            Payment Status:
                                            @if($testOrder->payment_status==\App\Models\TestOrder::PARTIALPAYMENT)
                                                <b class="badge badge-warning ">Partial Payment</b>

                                            @elseif($testOrder->payment_status==\App\Models\TestOrder::FULLPAYMENT)
                                                <b class="badge badge-primary">Full Paid</b>
                                            @else
                                                <b class="badge badge-danger ">Due</b>
                                            @endif
                                            <br>
                                            Hospital: <b>{{$testOrder->hospital->name}}</b> <br>
                                            Branch: {{$testOrder->hospital->branch}} <br>
                                            Address: {{$testOrder->hospital->address1}} <br>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                                                    <thead>
                                                    <tr class="">
                                                        <th width="4">SL.</th>
                                                        <th>Test</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i=1; ?>
                                                    @forelse($testOrder->testOrderDetails as $testOrderDetail)
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>{{$testOrderDetail->test->title}}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center"> No Data Found! </td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                <hr>

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Title</label>
                                        <div class="col-7">
                                            <input type="text" name="title" value="{{old('title',$testOrder->testReportFile?$testOrder->testReportFile->title:'')}}" required autocomplete="off" class="form-control" placeholder="Test Title">
                                            @if ($errors->has('title'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('title') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="col-2">
                                            {{Form::select('status', [\App\Models\TestOrderReportFile::ACTIVE  => 'Active' , \App\Models\TestOrderReportFile::INACTIVE  => 'Inactive'],$testOrder->testReportFile?$testOrder->testReportFile->status:'', ['class' => 'form-control'])}}

                                            @if ($errors->has('status'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('status') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Notes</label>
                                        <div class="col-9">

                                            <textarea rows="4" placeholder="Report Notes " class="form-control"  name="notes" cols="3">{{$testOrder->testReportFile?$testOrder->testReportFile->notes:''}}</textarea>
                                            @if ($errors->has('notes'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('notes') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                    {{Form::label('Report File', 'Report File', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-md-9">

                                        <div class="needsclick dropzone" id="document-dropzone">

                                            {{--<input name="attachment[]" type="file" class="needsclick dropzone" multiple--}}
                                                   {{--accept="image/jpg, image/jpeg, image/png">--}}

                                        {{--<input type="file" id="file" style="display: none;" name="report_files[]" accept="image/*" onchange="photoLoad(this, this.id)" />--}}

                                        @if ($errors->has('icon_photo'))
                                            <span class="help-block" style="display:block">
                                        <strong>{{ $errors->first('icon_photo') }}</strong>
                                    </span>
                                                    @endif
                                        </div>
                                    </div>
                                 </div>
                                @if($testOrder->testReportFile)
                                <div class="row">
                                    <input type="hidden" name="id" value="{{$testOrder->testReportFile->id}}" id="testReportId" />
                                    @foreach($testOrder->testReportFile->files as $key=>$file)

                                    <div class="col-md-3">
                                        <div class="thumbnail">
                                            <a href="{{asset($file)}}" target="_blank">
                                                <img src="{{asset($file)}}" alt="Lights" style="width: 100%;padding-bottom: 5px;" class="img-responsive">
                                            </a>
                                            <div class="caption text-center">
                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteTestReportFile(this)" data-reportFile="{{$file}}" id="{{$key}}"> <i class="icofont icofont-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                        </div>
                        <div class="card-footer">
                            <div class="row">

                                <div class="col-10">
                                    <button type="submit" class="btn btn-warning form-footer">Submit</button>
                                </div>
                                <div class="col-2">
                                    <a href="{{url('admin/test-orders')}}" class="btn btn-secondary pull-right">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </div>
                {!! Form::close() !!}
                    <!-- end of form -->
                </div>
            </div>
            <!-- Table header styling table end -->
        </div>
        <!-- Page-body end -->
    </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

    <script>

        console.log($('input[name=test_order_id]').val())
        var uploadedDocumentMap = {}
        let asyncExtraData = {
            inventory_title: 'Attachment',
            test_order_id  : $('input[name=test_order_id]').val(),
            _token         : "{{ csrf_token() }}",
        }
        Dropzone.options.documentDropzone = {
            url: "{{ route('admin.test-reports-upload') }}",
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            showCaption:true,
            uploadAsync: true,
            acceptedFiles: ".jpeg,.jpg,.png",
            params:{
                id:$('input[name=title]').val(),
                title:$('input[name=title]').val(),
                test_order_id: $('input[name=test_order_id]').val(),
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },

            success: function (file, response) {
                console.log(response)
                $('.report-form').append('<input type="hidden" name="attachment[]" value="' + response.name + '" accept="image/*">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('.report-form').find('input[name="attachment[]"][value="' + name + '"]').remove()
            },
            init: function () {
                        @if(isset($project) && $project->document)
                var files =
                {!! json_encode($project->document) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('.report-form').append('<input type="hidden" name="attachment[]" value="' + file.file_name + '" accept="image/*">')
                }
                @endif
            }
        }
    </script>

    <script>
        //"use strict";
        function deleteTestReportFile(fileVal) {

            var confirmationData= confirm('Are you sure? You want to delete this file');
            var filePath=fileVal.getAttribute('data-reportFile')
            var testOrderId=$('#testOrderId').val()
            var testReportId=$('#testReportId').val()
            var id=fileVal.getAttribute('id')

            if (confirmationData){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "{{ url('admin/test-reports-delete') }}",
                    data : { 'file_path':filePath,'id':testReportId,'test_order_id':testOrderId},
                    type : 'POST',
                    dataType : 'json',
                    success : function(result){
                        alert('Report File Successfully Delete')
                        $('#'+id).parent().parent().hide()
                    },
                    error: function (data) {
                        console.log(data);
                        alert(data)
                    }
                });
            }

        }


    </script>


@endsection