@extends('admin.layout.app')
@section('title')
    Districts List
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Districts List </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Districts List</h5>
                        <span> </span>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            {{--<i class="icofont icofont-refresh"></i>--}}
                            {{--<i class="icofont icofont-close-circled"></i>--}}
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                                <thead>
                                <tr class="">
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Name BN</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                @forelse($allData as $data)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td> {{$data->name}}</td>
                                        <td> {{$data->bn_name}}</td>

                                        <td>
                                            @if($data->status==\App\Models\District::ACTIVE)
                                                <i class="icofont icofont-check-circled icofont-2x text-success"></i> Active
                                            @elseif($data->status==\App\Models\District::INACTIVE)
                                                <i class="icofont icofont-ui-close text-danger"></i> Inactive
                                            @elseif($data->status==\App\Models\District::OTHER)
                                                <i class="fa fa-bolt text-info"></i> Other
                                            @endif
                                        </td>

                                        <td>
                                            {!! Form::open(array('route' => ['admin.districts.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                            <a href="#editFormModal{{$data->id}}" data-toggle="modal" data-target="#editFormModal{{$data->id}}" class="btn btn-success btn-sm"><i class="icofont icofont-edit"></i> </a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="icofont icofont-trash"></i></button>
                                            <a href="{{route('admin.areas.index',['district_id'=>$data->id]) }}" class="btn btn-info btn-sm" target="_blank"><b>+ New Area ({{$data->zone_area_count}})</b> </a>
                                            {!! Form::close() !!}
                                        </td>




                                        <!-- begin::modal -->

                                        <div class="modal fade show" id="editFormModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    {!! Form::open(array('route' => ['admin.districts.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                                    <div class="modal-header modal-header-primary">
                                                        <h5 class="modal-title" id="">Edit  District</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" class="la la-remove"></span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                            {{Form::label('name', 'Name', array('class' => 'col-md-2 control-label'))}}
                                                            <div class="col-md-8">
                                                                {{Form::text('name',$value=$data->name,array('class'=>'form-control','placeholder'=>'District Name','required','autofocus'))}}
                                                                @if ($errors->has('name'))
                                                                    <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('name') }}</strong>
                    			</span>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-2">
                                                                {{Form::select('status', [\App\Models\District::ACTIVE  => 'Active' ,
                                                                \App\Models\District::INACTIVE  => 'Inactive'],$data->status, ['class' => 'form-control'])}}
                                                            </div>
                                                        </div>

                                                        <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                            {{Form::label('Bn name', 'Bn Name', array('class' => 'col-md-2 control-label'))}}
                                                            <div class="col-md-8">
                                                                {{Form::text('bn_name',$value=$data->bn_name,array('class'=>'form-control','placeholder'=>'District Name','autofocus'))}}
                                                                @if ($errors->has('bn_name'))
                                                                    <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('bn_name') }}</strong>
                    			</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div><!--end body-->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-warning" style="cursor: pointer;">Submit</button>
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                    <!-- <button type="button" class="btn btn-secondary">Submit</button> -->
                                                </div>
                                                {!! Form::close() !!}
                                            </div><!--end content-->

                                        </div>
                                        </div>

                                        <!-- end::modal -->


                                    </tr>
                        @empty

                            <tr>
                                <td colspan="8" class="text-center"> No Category Data ! </td>
                            </tr>
                            @endforelse

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table header styling table end -->
        </div>
        <!-- Page-body end -->
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        function photoLoad(input,image_load) {
            var target_image='#'+$('#'+image_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection