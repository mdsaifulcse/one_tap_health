@extends('admin.layout.app')
@section('title')
    Biggapon Create & List
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Biggapon Create & List </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="#"  class="btn btn-info btn-sm"><i class="icofont icofont-list"></i> Biggapon</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
                    <!-- Table header styling table start -->
                    {!! Form::open(array('route' => 'admin.biggapons.store','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                    <div class="card">
                        <div class="card-header">
                            <h5> Create New Biggapon</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                <i class="icofont icofont-close-circled"></i>
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="form-group row">

                                <div class="col-md-3">
                                    {{Form::label('Biggapon Place', 'Biggapon Place', ['class' => 'control-label'])}}

                                    {{Form::select('place', $place,\App\Models\Biggapon::TOP, ['class' => 'form-control','id'=>'place','required'=>true,'placeholder'=>'--Select--'])}}
                                </div>
                                <div class="col-md-3" style="display:block;">
                                    {{Form::label('Show on', 'Show on', array('class' =>' control-label'))}}
                                    {{Form::select('show_on_page',$showOnPage,\App\Models\Biggapon::HOME_PAGE, ['class' => 'form-control','required'=>true,'id'=>'onPage','placeholder'=>'-- Select --'])}}
                                </div>


                                <div class="col-md-3">
                                    {{Form::label('serial', 'Serial', array('class' => ' control-label'))}}
                                    {{Form::number('sequence',$value=$max_serial,array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"",'min'=>'0'))}}

                                </div>

                                <div class="col-md-3">
                                    {{Form::label('Status', 'Status', array('class' => 'control-label'))}}
                                    {{Form::select('status', $status,[], ['class' => 'form-control','required'=>true])}}

                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="slide_photo" class="imageSize control-label">Image </label>
                                    <label class="slide_upload" for="file">

                                        <img id="image_load" src="{{asset('images/default/default.png')}}" class="img img-responsive img-thumbnail">

                                    </label>

                                    <input id="file" style="display:none" required="" name="image" type="file" accept="image/*" onchange="photoLoad(this,this.id)">
                                </div>
                                <div class="col-md-9">
                                    <label for="text" class="col-md-3 control-label">{{ __('Target Link') }}</label>

                                    <div class="col-md-9" >
                                        <input type="text" class="form-control" name="target_url" value="{{old('target_url')}}" placeholder="Target Link Here"/>

                                        @if ($errors->has('target_url'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('target_url') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">

                                <div class="col-10">
                                    <button type="submit" class="btn btn-warning form-footer">Submit</button>

                                </div>
                                {{--<div class="col-2">--}}
                                    {{--<a href="#" class="btn btn-secondary pull-right">Cancel</a>--}}
                                {{--</div>--}}
                            </div>

                        </div>
                    </div> <!-- end card -->
                {!! Form::close() !!}
                    <!-- end of form -->
                </div><!--end col-->
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Biggapon List</h5>
                        <span> </span>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            {{--<i class="icofont icofont-refresh"></i>--}}
                            {{--<i class="icofont icofont-close-circled"></i>--}}
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover table-bordered center_table">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>image</th>
                                    <th>Show On Page</th>
                                    <th>Place</th>
                                    <th>Link</th>
                                    <th>Sequence</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>

                                <?php $i=1; ?>
                                @forelse($alldata as $data)

                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            <img src="{{asset($data->image)}}" style="width: 100px;
    height:auto;"/>
                                        </td>

                                        <td>{{$data->show_on_page}}</td>
                                        <td>{{$data->place}}</td>

                                        <td> <a href="{{$data->target_url}}" target="_blank"> {{$data->target_url}}</a> </td>
                                        <td>{{$data->sequence}}</td>

                                        <td><i class="{{($data->status==\App\Models\Biggapon::ACTIVE)? 'icofont icofont-check-circled icofont-2x text-success' : 'icofont icofont-ui-close text-danger'}}"></i></td>

                                        <td>
                                            {{Form::open(array('route'=>['admin.biggapons.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id"))}}

                                            <a href='#sliderModal{{$data->id}}' data-target="#biggaponModal{{$data->id}}" data-toggle="modal" title="Edit Biggapon" class="btn btn-info btn-sm">
                                                <i class="icofont icofont-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="return deleteConfirm('deleteForm{{$data->id}}')">
                                                <i class="icofont icofont-trash"></i>
                                            </button>
                                            {!! Form::close() !!}
                                        </td>

                                        <!-- Modal Start -->
                                        <div class="modal fade" id="biggaponModal{{$data->id}}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    {!! Form::open(['route' => ['admin.biggapons.update',$data->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true]) !!}
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Biggapon Info </h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group row">

                                                            <div class="col-md-3">
                                                                {{Form::label('Biggapon Place', 'Biggapon Place', ['class' => 'control-label'])}}

                                                                {{Form::select('place', $place,$data->place, ['class' => 'form-control','id'=>'place','required'=>true,'placeholder'=>'--Select--'])}}
                                                            </div>
                                                            <div class="col-md-3" style="display:block;">
                                                                {{Form::label('Show on', 'Show on', array('class' =>' control-label'))}}
                                                                {{Form::select('show_on_page',$showOnPage,$data->show_on_page, ['class' => 'form-control','required'=>true,'id'=>'onPage','placeholder'=>'-- Select --'])}}
                                                            </div>


                                                            <div class="col-md-3">
                                                                {{Form::label('serial', 'Serial', array('class' => ' control-label'))}}
                                                                {{Form::number('sequence',$value=$data->sequence,array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max_serial",'min'=>'0'))}}

                                                            </div>

                                                            <div class="col-md-3">
                                                                {{Form::label('Status', 'Status', array('class' => 'control-label'))}}
                                                                {{Form::select('status', $status,$data->status, ['class' => 'form-control','required'=>true])}}

                                                            </div>

                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-3">
                                                                <label for="slide_photo" class="imageSize control-label">Image </label>
                                                                <label class="slide_upload" for="file{{$data->id}}">
                                                                    @if(file_exists($data->image))
                                                                        <img id="image_load{{$data->id}}" src="{{asset($data->image)}}" class="img img-responsive img-thumbnail">
                                                                    @else
                                                                        <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" class="img img-responsive img-thumbnail">
                                                                    @endif
                                                                </label>

                                                                <input id="file{{$data->id}}" style="display:none" name="image" type="file" accept="image/*" onchange="photoLoad(this,this.id)">
                                                            </div>
                                                            <div class="col-md-9">
                                                                <label for="text" class="col-md-3 control-label">{{ __('Target Link') }}</label>

                                                                <div class="col-md-9" >
                                                                    <input type="text" class="form-control" name="target_url" value="{{$data->target_url}}" placeholder="Target Link Here"/>

                                                                    @if ($errors->has('target_url'))
                                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('target_url') }}</strong>
                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!--end body -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-sm btn-success ">Update</button>
                                                        <a href="javascript:;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</a>
                                                    </div>
                                                    {!! Form::close(); !!}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal End -->
                                    </tr>
                                @empty
                                    <tr> <td colspan="7" class="text-center">No Biggapon Data Found !</td></tr>
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
            console.log(target_image)

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