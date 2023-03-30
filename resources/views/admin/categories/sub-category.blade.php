@extends('admin.layout.app')
@section('title')
   Sub Categories Create & List
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Sub Categories Create & List </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{url('admin/categories')}}" class="btn btn-info btn-sm" title="Back to Category List"><i class="icofont icofont-arrow-left"></i> Category</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
                    {!! Form::open(array('route' => 'admin.sub-categories.store','class'=>'','files'=>true)) !!}
                    <div class="card">
                        <div class="card-header">
                            <h5> Create New Sub Categories</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                <i class="icofont icofont-close-circled"></i>
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="form-group row {{ $errors->has('sub_category_name') ? 'has-error' : '' }}">
                                {{Form::label('sub_category_name', __('Sub-category'), array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-8">
                                    {{Form::text('sub_category_name',$value=old('sub_category_name'),array('class'=>'form-control','placeholder'=>__('Sub-category'),'required','autofocus'))}}

                                    <input type="hidden" name="category_id" value="{{$category->id}}">

                                    @if ($errors->has('sub_category_name'))
                                        <span class="help-block"><strong class="text-danger">{{ $errors->first('sub_category_name') }}</strong>
                            </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    {{Form::select('status', [\App\Models\SubCategory::ACTIVE  => 'Active' , \App\Models\SubCategory::INACTIVE  =>'Inactive'],[], ['class' => 'form-control'])}}
                                </div>
                            </div>


                            <div class="form-group row">
                                {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-10">
                                    {{Form::textArea('short_description',$value=old('short_description'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description for Home Page'])}}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-2">
                                    <label class="upload_photo upload icon_upload" for="file">
                                        <!--  -->
                                        <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                        {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                    </label>
                                    <input type="file" id="file" style="display: none;" name="icon_photo" onchange="photoLoad(this, this.id)" accept="image/*" />
                                    @if ($errors->has('icon_photo'))
                                        <span class="help-block" style="display:block">
                                            <strong>{{ $errors->first('icon_photo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <b>OR</b>
                                </div>
                                <div class="col-md-5">
                                    {{Form::text('icon_class','',array('class'=>'form-control','placeholder'=>'Ex: fa fa-facebook, ion-gear-a'))}}
                                    <span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/" target="_blank">Font Awesome</a>,
                                        <a class="btn btn-link" href="http://ionicons.com/" target="_blank">ion icons</a></span>
                                </div>
                                <?php $max=$max_serial+1; ?>
                                <div class="col-md-2">
                                    {{Form::number('sequence',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                    <span>Category Serial</span>
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
                        <h5>SubCategory List</h5>
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
                                    <th>Sub Category</th>
                                    <th>Category</th>
                                    <th>Third Sub-Category</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                @forelse($allData as $data)
                                    <tr>
                                        <td>{{$data->sequence}}</td>
                                        <td> {{$data->sub_category_name}}</td>
                                        <td><a href="#"><i class="{{$data->icon_class}}"></i> {{$data->category_name}}</a></td>

                                        <td>
                                            {{--@can('third-sub-categories')--}}
                                            <a class="btn btn-sm btn-sm btn-info" href='{{route('admin.third-sub-categories.show',$data->id)}}'>Third Sub Category ({{$data->thirdSubCategory->count()}})</a>
                                            {{--@endcan--}}
                                        </td>

                                        <td><i class="{{($data->status==\App\Models\SubCategory::ACTIVE)? 'icofont icofont-check-circled icofont-2x text-success' : 'icofont icofont-ui-close icofont-2x text-danger'}}"></i></td>

                                        <td>{{$data->created_at->diffForHumans()}}</td>
                                        <td>
                                            {!! Form::open(array('route' => ['admin.sub-categories.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                            <a href="#subCategoryModal{{$data->id}}" data-toggle="modal" data-target="#subCategoryModal{{$data->id}}" class="btn btn-success btn-sm"><i class="icofont icofont-edit"></i> </a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="icofont icofont-trash"></i></button>
                                            {!! Form::close() !!}
                                        </td>



                                        <!-- begin::modal -->

                                        <div class="modal fade show" id="subCategoryModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    {!! Form::open(array('route' => ['admin.sub-categories.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                                    <div class="modal-header modal-header-primary">
                                                        <h5 class="modal-title" id="">Edit Sub Category Info | {{$data->sub_category_name}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" class="la la-remove"></span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                            {{Form::label('category_name', 'Sub-category Name', array('class' => 'col-md-2 control-label'))}}
                                                            <div class="col-md-8">
                                                                {{Form::text('sub_category_name',$value=$data->sub_category_name,array('class'=>'form-control','placeholder'=>'Sub-category Name','required','autofocus'))}}

                                                                <input type="hidden" name="category_id" value="{{$category->id}}">

                                                                @if ($errors->has('sub_category_name'))
                                                                    <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('sub_category_name') }}</strong>
                    			</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{Form::select('status', [\App\Models\SubCategory::ACTIVE  => 'Active' , \App\Models\SubCategory::INACTIVE  => 'Inactive',],$data->status, ['class' => 'form-control'])}}
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                                            <div class="col-md-10">
                                                                {{Form::textArea('short_description',$value=$data->short_description, ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description for Home Page'])}}
                                                            </div>
                                                        </div>

                                                        <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                                            {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
                                                            <div class="col-md-2">
                                                                <label class="upload_photo upload icon_upload" for="file{{$data->id}}">
                                                                    <!--  -->
                                                                    @if(!empty($data->icon_photo) && file_exists($data->icon_photo))
                                                                        <img id="image_load{{$data->id}}" src="{{asset($data->icon_photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                                    @else
                                                                        <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                                    @endif
                                                                </label>
                                                                <input type="file" id="file{{$data->id}}" accept="image/*" style="display: none;" name="icon_photo" onchange="photoLoad(this, this.id)" />
                                                                @if ($errors->has('icon_photo'))
                                                                    <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('icon_photo') }}</strong>
                        </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-1">
                                                                <b>OR</b>
                                                            </div>
                                                            <div class="col-md-5">
                                                                {{Form::text('icon_class',$data->icon_class,array('class'=>'form-control','placeholder'=>'Ex: fa fa-facebook, ion-gear-a'))}}
                                                                <span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/" target="_blank">Font Awesome</a>,
                                                                    <a class="btn btn-link" href="http://ionicons.com/" target="_blank">ion icons</a></span>
                                                            </div>
                                                            <?php $max=$max_serial+1; ?>
                                                            <div class="col-md-2">
                                                                {{Form::number('sequence',$data->sequence, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                                                <span>Category Serial</span>
                                                            </div>
                                                        </div>

                                                    </div><!-- end body -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-brand" style="cursor: pointer;">Submit</button>
                                                        <button type="button" class="btn btn-secondary  pull-right" data-dismiss="modal">Close</button>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div><!-- end content -->

                                            </div>
                                        </div>

                                        <!-- end::modal -->

                                    </tr>
                                @empty

                                    <tr>
                                        <td colspan="8" class="text-center"> No Data Found ! </td>
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