@extends('admin.layout.app')
@section('title')
   Create Test | Dashboard
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Create Test </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.tests.index')}}" class="btn btn-info btn-sm" title="Test List here"><i class="icofont icofont-list"></i> Test List</a>
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
                        {!! Form::open(array('route' => 'admin.tests.store','class'=>'','files'=>true)) !!}

                    <div class="card">
                        <div class="card-header">
                            <h5>Create new Test</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="">

                                    <div class="form-group row">

                                        <div class="col-2">
                                        </div>
                                        <div class="col-3">

                                            <label for="example-text-input" class="col-form-label">{{__('admin.Category Name')}}<sup class="text-danger">*</sup></label>

                                            {!! Form::select('category_id',$categories,[], ['id'=>'loadSubCategory','placeholder' => '--Select Category --','class' => 'form-control select2tags','required'=>true]) !!}

                                            @if ($errors->has('category_id'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('category_id') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                        <div class="col-3">

                                            <label for="example-text-input" class="col-form-label">{{__('admin.Sub Category Name')}}<sup class="text-danger">*</sup></label>
                                            <div class="" id="subCategoryList">
                                                {!! Form::select('subcategory_id',[],[], ['id'=>'loadThirdSubCategory','placeholder' => 'First Select Category','class' => 'form-control select2tags','required'=>true]) !!}

                                                @if ($errors->has('subcategory_id'))
                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('subcategory_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-3">
                                            <label for="example-text-input" class="col-form-label">{{__('admin.Third Sub-Category')}}</label>
                                            <div class="" id="thirdSubCategoryList">
                                                {!! Form::select('third_category_id',[],[], ['id'=>'loadFourthSubCategory','placeholder' => 'First Sub-Category','class' => 'form-control','required'=>false]) !!}

                                                @if ($errors->has('third_category_id'))
                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('third_category_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div> <!-- end row-->

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Title</label>
                                        <div class="col-7">
                                            <input type="text" name="title" value="{{old('title')}}" required autocomplete="off" class="form-control" placeholder="Test Title">
                                            @if ($errors->has('title'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('title') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="col-2">
                                            {{Form::select('status', [\App\Models\Category::ACTIVE  => 'Active' , \App\Models\Category::INACTIVE  => 'Inactive'],[], ['class' => 'form-control'])}}
                                            <span>Status</span>

                                            @if ($errors->has('status'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('status') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Sub Title</label>
                                        <div class="col-7">
                                            <input type="text" name="sub_title" value="{{old('sub_title')}}" required autocomplete="off" class="form-control" placeholder="Test sub title">
                                            @if ($errors->has('sub_title'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('sub_title') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <?php $max=$maxSerial+1; ?>
                                        <div class="col-md-2">
                                            {{Form::number('sequence',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                            <span>Sequence</span>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Description</label>
                                        <div class="col-9">

                                            <textarea rows="4" placeholder="Test Description " class="form-control"  name="description" cols="5"></textarea>
                                            @if ($errors->has('description'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                    {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label text-right'))}}
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
                                        {{Form::text('icon_class','',array('class'=>'form-control ','placeholder'=>'Ex: fa fa-facebook, ion-gear-a'))}}
                                        <span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/" target="_blank">Font Awesome</a>, <a class="btn btn-link" href="http://ionicons.com/" target="_blank">ion icons</a></span>
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
                                    <a href="{{url('admin/tests')}}" class="btn btn-secondary pull-right">Cancel</a>
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
@endsection

@section('script')

    {{--Load SubCategory--}}
    <script>
        $('#loadSubCategory').on('change',function () {

            var categoryId=$(this).val()

            $('#loadFourthSubCategory').empty()
            $('#fourthSubCategory').empty()

            if(categoryId.length===0)
            {
                categoryId=0
                $('#subCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("admin/load-sub-cat-by-cat")}}/'+categoryId);

            }else {

                $('#subCategoryList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("admin/load-sub-cat-by-cat")}}/'+categoryId);
            }
        })
    </script>

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