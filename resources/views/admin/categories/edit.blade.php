@extends('admin.layout.app')
@section('title')
    Edit Category
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Edit Category </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.categories.index')}}" class="btn btn-info btn-sm" ><i class="icofont icofont-list"></i> Category</a>
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
                    {!! Form::open(['route' => ['admin.categories.update',$data->id],'method'=>'PUT','class'=>'','files'=>true]) !!}
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Category | {{$data->category_name}}</h5>
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
                                        {{Form::select('status', [\App\Models\Category::ACTIVE  => 'Active' , \App\Models\Category::INACTIVE  => 'Inactive'],$data->status, ['class' => 'form-control'])}}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                    <div class="col-md-10">
                                        {{Form::textArea('short_description',$value=$data->short_description, ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description'])}}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                    {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
                                    <div class="col-md-2">
                                        <label class="upload_photo upload icon_upload" for="file">
                                            <!--  -->
                                            @if(!empty($data->icon_photo) && file_exists($data->icon_photo))
                                                <img id="image_load" src="{{asset($data->icon_photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                            @else
                                                <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                            @endif
                                            {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                        </label>
                                        <input type="file" id="file" style="display: none;" name="icon_photo"  accept="image/*" onchange="photoLoad(this, this.id)" />
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
                                        {{Form::number('sequence',$data->sequence, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
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
                                <div class="col-2">
                                    <a href="{{url('admin/categories')}}" class="btn btn-secondary pull-right">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    {!! Form::close() !!}
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