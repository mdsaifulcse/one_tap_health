@extends('admin.layout.app')
@section('title')
    Categories Create & List
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Categories Create & List </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="#"  class="btn btn-info btn-sm"><i class="icofont icofont-list"></i> Category</a>
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
                    {!! Form::open(array('route' => 'admin.categories.store','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                    <div class="card">
                        <div class="card-header">
                            <h5> Create New Category</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                <i class="icofont icofont-close-circled"></i>
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="">

                                <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {{Form::label('category_name', __("admin.Category Name"), array('class' => 'col-md-2 control-label'))}}
                                    <div class="col-md-8">
                                        {{Form::text('category_name',$value=old('category_name'),array('class'=>'form-control','placeholder'=>__('admin.Category Name'),'required','autofocus'))}}
                                        @if ($errors->has('category_name'))
                                            <span class="help-block"><strong class="text-danger">{{ $errors->first('category_name') }}</strong></span>
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        {{Form::select('status', [\App\Models\Category::ACTIVE  => 'Active' , \App\Models\Category::INACTIVE  => 'Inactive',
                                        \App\Models\Category::OTHER  => 'Other'],[], ['class' => 'form-control'])}}
                                    </div>
                                </div>

                                {{--<div class="form-group row {{ $errors->has('category_name_bn') ? 'has-error' : '' }}">--}}
                                    {{--{{Form::label('category_name_bn', __("admin.Category Name Bn"), array('class' => 'col-md-2 control-label'))}}--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--{{Form::text('category_name_bn',$value=old('category_name_bn'),array('class'=>'form-control','placeholder'=>__('admin.Category Name Bn'),'required','autofocus'))}}--}}
                                        {{--@if ($errors->has('category_name_bn'))--}}
                                            {{--<span class="help-block"><strong class="text-danger">{{ $errors->first('category_name_bn') }}</strong></span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group row {{ $errors->has('url') ? 'has-error' : '' }}">--}}
                                    {{--{{Form::label('URL', 'Category Url', array('class' => 'col-md-2 control-label'))}}--}}

                                    {{--<div class="col-md-8">--}}
                                        {{--{{Form::text('link',$value=old('link'),array('class'=>'form-control','placeholder'=>'Optional'))}}--}}

                                        {{--@if ($errors->has('link'))--}}
                                            {{--<span class="help-block">--}}
                        				    {{--<strong class="text-danger">{{ $errors->first('link') }}</strong>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-2">--}}
                                        {{--{{Form::select('show_home', [\App\Models\Category::NO  => 'No' ,--}}
                                        {{--\App\Models\Category::YES  => 'Yes'],[], ['class' => 'form-control'])}}--}}
                                        {{--<span class="text-success">Show at home page</span>--}}
                                    {{--</div>--}}

                                {{--</div>--}}

                                <div class="form-group row">
                                    {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                    <div class="col-md-10">
                                        {{Form::textArea('short_description',$value=old('short_description'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description'])}}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                    {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
                                    <div class="col-md-2">
                                        <label class="upload_photo upload icon_upload" for="file">
                                            <!--  -->
                                            <img id="image_load" src="{{asset('images/default/default.png')}}"  style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                            {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                        </label>
                                        <input type="file" id="file" style="display: none;" name="icon_photo" accept="image/*" onchange="photoLoad(this, this.id)" />
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
                                        <span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/" target="_blank">Font Awesome</a>, <a class="btn btn-link" href="http://ionicons.com/" target="_blank">ion icons</a></span>
                                    </div>
                                    <?php $max=$max_serial+1; ?>
                                    <div class="col-md-2">
                                        {{Form::number('sequence',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                        <span>Category Serial</span>
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
                        <h5>Category List</h5>
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
                                    <th>URL</th>
                                    <th>Sub Category</th>
                                    <th>Status</th>
                                    <th>Show Home page</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                @forelse($allData as $data)
                                    <tr>
                                        <td>{{$data->serial_num}}</td>
                                        <td><a href="{{route('admin.categories.edit',$data->id)}}"><i class="{{$data->icon_class}}"></i> {{$data->category_name}}</a></td>
                                        <td>{{$data->link}}</td>

                                        <td>

                                            <a class="btn btn-sm btn-sm btn-info" href='{{route('admin.sub-categories.show',$data->id)}}'>Sub Category ({{$data->subCategoryData->count()}})</a>

                                            {{--@can('sub-categories')--}}
                                                {{--<a class="btn btn-sm btn-sm btn-info" href='{{route('sub-categories.show',$data->id)}}'>Sub Category ({{$data->subCategoryData->count()}})</a>--}}
                                            {{--@endcan--}}
                                        </td>

                                        <td>
                                            @if($data->status==\App\Models\Category::ACTIVE)
                                                <i class="icofont icofont-check-circled icofont-2x text-success"></i> Active
                                            @elseif($data->status==\App\Models\Category::INACTIVE)
                                                <i class="icofont icofont-ui-close text-danger"></i> Inactive
                                            @elseif($data->status==\App\Models\Category::OTHER)
                                                <i class="fa fa-bolt text-info"></i> Other
                                            @endif
                                        </td>
                                        <td>
                                            @if($data->show_home==\App\Models\Category::YES)
                                                <i class="icofont icofont-check-circled text-success"></i> Yes
                                            @elseif($data->show_home==\App\Models\Category::NO)
                                                <i class="icofont icofont-ui-close text-danger"></i> No
                                            @elseif($data->show_home==\App\Models\Category::OTHER)
                                                <i class="fa fa-bolt text-info"></i> Other
                                            @endif
                                        </td>

                                        <td>{{$data->created_at->diffForHumans()}}</td>
                                        <td>
                                            {!! Form::open(array('route' => ['admin.categories.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                            <a href="#categoryModal{{$data->id}}" data-toggle="modal" data-target="#categoryModal{{$data->id}}" class="btn btn-success btn-sm"><i class="icofont icofont-edit"></i> </a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="icofont icofont-trash"></i></button>
                                            {!! Form::close() !!}
                                        </td>




                                        <!-- begin::modal -->

                                        <div class="modal fade show" id="categoryModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    {!! Form::open(array('route' => ['admin.categories.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                                    <div class="modal-header modal-header-primary">
                                                        <h5 class="modal-title" id="">Edit  Category Info | {{$data->category_name}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" class="la la-remove"></span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                            {{Form::label('category_name', 'Category Name', array('class' => 'col-md-2 control-label'))}}
                                                            <div class="col-md-8">
                                                                {{Form::text('category_name',$value=$data->category_name,array('class'=>'form-control','placeholder'=>'Category Name','required','autofocus'))}}
                                                                @if ($errors->has('category_name'))
                                                                    <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('category_name') }}</strong>
                    			</span>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-2">
                                                                {{Form::select('status', [\App\Models\Category::ACTIVE  => 'Active' ,
                                                                \App\Models\Category::INACTIVE  => 'Inactive',\App\Models\Category::OTHER  => 'Other'],$data->status, ['class' => 'form-control'])}}
                                                            </div>
                                                        </div>

                                                        {{--<div class="form-group row {{ $errors->has('category_name_bn') ? 'has-error' : '' }}">--}}

                                                            {{--{{Form::label('category_name_bn', __('Category Name Bn'), array('class' => 'col-md-2 control-label'))}}--}}
                                                            {{--<div class="col-md-8">--}}
                                                                {{--{{Form::text('category_name_bn',$value=old('category_name_bn',$data->category_name_bn),array('class'=>'form-control','placeholder'=>__('Category Name Bn'),'required','autofocus'))}}--}}
                                                                {{--@if ($errors->has('category_name_bn'))--}}
                                                                    {{--<span class="help-block"><strong class="text-danger">{{ $errors->first('category_name_bn') }}</strong></span>--}}
                                                                {{--@endif--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}


                                                    {{--<div class="form-group row {{ $errors->has('link') ? 'has-error' : '' }}">--}}
                                                        {{--{{Form::label('Link', 'URL', array('class' => 'col-md-2 control-label'))}}--}}
                                                        {{--<div class="col-md-8">--}}
                                                            {{--{{Form::text('link',$value=$data->link,array('class'=>'form-control','placeholder'=>'Category Name','required','autofocus'))}}--}}
                                                            {{--@if ($errors->has('link'))--}}
                                                                {{--<span class="help-block">--}}
                        				{{--<strong class="text-danger">{{ $errors->first('link') }}</strong>--}}
                    			{{--</span>--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}

                                                        {{--<div class="col-md-2">--}}
                                                            {{--{{Form::select('show_home', [\App\Models\Category::NO  => 'No' ,--}}
                                                             {{--\App\Models\Category::YES  => 'Yes'],$data->show_home, ['class' => 'form-control'])}}--}}
                                                            {{--<span class="text-success">Show at home page</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}


                                                    <div class="form-group row">
                                                        {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                                        <div class="col-md-10">
                                                            {{Form::textArea('short_description',$value=$data->short_description, ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description'])}}
                                                        </div>
                                                    </div>

                                                    <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                                        {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
                                                        <div class="col-md-2">
                                                            <label class="upload_photo upload icon_upload" for="file{{$data->id}}">
                                                                <!--  -->
                                                                @if(!empty($data->icon_photo))
                                                                    <img id="image_load{{$data->id}}" src="{{asset($data->icon_photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                                @else
                                                                    <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                                                @endif
                                                                {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                                            </label>
                                                            <input type="file" id="file{{$data->id}}" style="display: none;"  accept="image/*" name="icon_photo" onchange="photoLoad(this, this.id)" />
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
                                                                <a class="btn btn-link" href="http://ionicons.com/"  target="_blank">ion icons</a></span>
                                                        </div>
                                                        <?php $max=$max_serial+1; ?>
                                                        <div class="col-md-2">
                                                            {{Form::number('sequence',$data->sequence, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                                            <span>Category Serial</span>
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
                                <td colspan="8" class="text-center"> No Menu Data ! </td>
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