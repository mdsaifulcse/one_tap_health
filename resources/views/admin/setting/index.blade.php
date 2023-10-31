@extends('admin.layout.app')
@section('title')
    Update Site Setting
@endsection

@section('style')
    <style>
        #dom-jqry_filter{
            margin-top:-28px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            background-color: white;
            color: #000000;
        }
        .select2-results__option:first-child{
            display: none;
        }
        #mceu_90,#mceu_91, #mceu_92{
            display: none !important;
        }
        .mce-widget .mce-notification .mce-notification-warning .mce-has-close .mce-in{
            display: none !important;
        }
    </style>
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Update Site Setting </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="#" class="btn btn-info btn-sm"  title="Hospital List here"><i class="icofont icofont-list"></i>    </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-md-12 ">
                    <!-- Form -->
                    {!! Form::open(array('route' => ['admin.setting.update',$data->id],'method'=>'PUT','class'=>'','files'=>true)) !!}

                    <div class="card">
                        <div class="card-header">
                            <h5>Create new Patient</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                {{--<i class="icofont icofont-close-circled"></i>--}}
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="login-card0 auth-body0">

                                <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <div class="col-md-6">
                                        {{Form::label('Company Name', 'Company Name', array('class' => ' control-label'))}}

                                        {{Form::text('company_name',$value=$data->company_name,array('class'=>'form-control','placeholder'=>'Company Name','required','autofocus'))}}

                                        @if ($errors->has('company_name'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('company_name') }}</strong>
                    			         </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        {{Form::label('Company Title', 'Company Title', array('class' => ' control-label'))}}

                                        {{Form::text('company_title',$value=$data->company_title,array('class'=>'form-control','placeholder'=>'Company Title'))}}

                                        @if ($errors->has('company_title'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('company_title') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                </div><!-- end row -->


                                <div class="form-group row">

                                    <div class="col-md-6">

                                        {{Form::label('slogan', 'Company Slogan', array('class' => ' control-label'))}}
                                        {{Form::text('company_slogan',$value=$data->company_slogan,array('class'=>'form-control','placeholder'=>'Company Slogan'))}}

                                        @if ($errors->has('company_slogan'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('company_slogan') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3">

                                        {{Form::label('copyright', 'Company copyright', array('class' => ' control-label'))}}
                                        {{Form::text('copyright',$value=$data->copyright,array('class'=>'form-control','placeholder'=>'Company copyright'))}}

                                        @if ($errors->has('copyright'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('copyright') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-1">
                                        <label class="upload_photo upload icon_upload" for="logo">
                                            Logo

                                            @if(isset($data->logo))
                                                <img id="logo_load" src="{{asset($data->logo)}}" style="max-width: 90px;border: 2px dashed #2783bb; cursor: pointer">
                                            @else
                                                <img id="logo_load" src="{{asset('images/default/default.png')}}" style="max-width: 90px;border: 2px dashed #2783bb; cursor: pointer">
                                            @endif

                                        </label>
                                        <input type="file" id="logo" style="display: none;" name="logo" onchange="photoLoad(this, this.id)" />
                                        @if ($errors->has('logo'))
                                            <span class="help-block" style="display:block">
                                            <strong>{{ $errors->first('logo') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="col-md-1">
                                        <label class="upload_photo upload icon_upload" for="favicon">
                                            Favicon

                                            @if(isset($data->favicon))
                                                <img id="favicon_load" src="{{asset($data->favicon)}}" style="max-width: 90px;border: 2px dashed #2783bb; cursor: pointer">
                                            @else
                                                <img id="favicon_load" src="{{asset('images/default/default.png')}}" style="max-width: 90px;border: 2px dashed #2783bb; cursor: pointer">
                                            @endif
                                        </label>
                                        <input type="file" id="favicon" style="display: none;" name="favicon" onchange="photoLoad(this, this.id)" />
                                        @if ($errors->has('favicon'))
                                            <span class="help-block" style="display:block">
                                            <strong>{{ $errors->first('favicon') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div><!-- end row -->



                                <div class="form-group row {{ $errors->has('currency') ? 'has-error' : '' }}">
                                    <div class="col-md-3">
                                        {{Form::label('Currency', 'Currency', array('class' => ' control-label'))}}

                                        <select name="currency" id="currency" value="{{$data->currency}}" required class="form-control">
                                            <option @if(App\Models\Setting::get('currency') == "৳") selected @endif data-id="BDT" value="৳">Bangladeshi Taka (BDT)</option>
                                            {{--<option @if(App\Models\Setting::get('currency') == "$") selected @endif data-id="USD" value="$">US Dollar (USD)</option>--}}

                                        </select>

                                        @if ($errors->has('currency'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('currency') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3">
                                        {{Form::label('Currency Code', 'Currency Code', array('class' => ' control-label'))}}

                                        {{Form::text('currency_code',$value=$data->currency_code,['id'=>'currency_code','class'=>'form-control','placeholder'=>'Currency Code'])}}

                                        @if ($errors->has('currency_code'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('
                        				    currency_code') }}</strong>
                    			         </span>
                                        @endif
                                    </div>


                                    <div class="col-md-3">
                                        {{Form::label('appointment_service_charge', 'Appointment Service Charge', array('class' => ' control-label'))}}

                                        {{Form::number('appointment_service_charge',$value=$data->appointment_service_charge,['min'=>10,'max'=>999,'class'=>'form-control','placeholder'=>'20tk'])}}

                                        @if ($errors->has('appointment_service_charge'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('appointment_service_charge') }}</strong>
                    			         </span>
                                        @endif
                                    </div>
                                    {{--<div class="col-md-6">--}}
                                        {{--{{Form::label('map', 'Embed map', array('class' => ' control-label'))}}--}}

                                        {{--{{Form::text('map_embed',$value=$data->map_embed,['class'=>'form-control','placeholder'=>'Google Map code here'])}}--}}

                                        {{--@if ($errors->has('map_embed'))--}}
                                            {{--<span class="help-block">--}}
                        				    {{--<strong class="text-danger">{{ $errors->first('map_embed') }}</strong>--}}
                    			         {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}

                                </div><!-- end row -->


                                <div class="form-group row">
                                    <div class="col-md-3">
                                        {{Form::label('Mobile', 'Primary Mobile', array('class' => ' control-label'))}}

                                        {{Form::text('mobile_no1',$value=$data->mobile_no1,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('mobile_no1'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('mobile_no1') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3">
                                        {{Form::label('Mobile', 'Secondary Mobile', array('class' => ' control-label'))}}

                                        {{Form::text('mobile_no2',$value=$data->mobile_no2,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('mobile_no2'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('mobile_no2') }}</strong>
                    			         </span>
                                        @endif
                                    </div>



                                    <div class="col-md-3">
                                        {{Form::label('Email', 'Primary Email', array('class' => ' control-label'))}}

                                        {{Form::text('email1',$value=$data->email1,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('email1'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('email1') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3">
                                        {{Form::label('Email', 'Secondary Email', array('class' => ' control-label'))}}

                                        {{Form::text('email2',$value=$data->email2,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('email2'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('email2') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                </div><!-- end row -->

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        {{Form::label('Address', 'Primary Address', array('class' => ' control-label'))}}

                                        {{Form::textArea('address1',$value=$data->address1,['rows'=>'2','class'=>'form-control','placeholder'=>'Primary Address '])}}

                                        @if ($errors->has('address1'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('address1') }}</strong>
                    			         </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        {{Form::label('Address', 'Secondary Address', array('class' => ' control-label'))}}

                                        {{Form::textArea('address2',$value=$data->address2,['rows'=>'2','class'=>'form-control','placeholder'=>'Secondary Address '])}}

                                        @if ($errors->has('address2'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('address2') }}</strong>
                    			         </span>
                                        @endif
                                    </div>
                                </div><!-- end row -->



                                <div class="form-group row">
                                    <div class="col-md-6">
                                        {{Form::label('short detail', 'Company Short Details', array('class' => ' control-label'))}}

                                        {{Form::textArea('short_description',$value=$data->short_description,['id'=>'kt-ckeditor-1','rows'=>'5','class'=>'form-control textarea','placeholder'=>'Company Short Details Here '])}}

                                        @if ($errors->has('short_description'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('short_description') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        {{Form::label('Details', 'Company Long Details', array('class' => ' control-label'))}}

                                        {{Form::textArea('description',$value=$data->description,['id'=>'kt-ckeditor-2','rows'=>'5','class'=>'form-control textarea','placeholder'=>'Company Long Details Here '])}}

                                        @if ($errors->has('description'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('description') }}</strong>
                    			         </span>
                                        @endif
                                    </div>
                                </div><!-- end row -->



                                <div class="form-group row">
                                    <div class="col-md-6">
                                        {{Form::label('Why Us', 'Why Us', array('class' => ' control-label'))}}

                                        {{Form::textArea('why_us',$value=$data->why_us,['id'=>'kt-ckeditor-3','rows'=>'4','class'=>'form-control textarea','placeholder'=>'Why Choose Us Here'])}}

                                        @if ($errors->has('why_us'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('why_us') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        {{Form::label('Meta Details', 'Company Meta Details', array('class' => ' control-label'))}}

                                        {{Form::textArea('meta_description',$value=$data->meta_description,['rows'=>'4','class'=>'form-control','placeholder'=>'Company Meta Details Here '])}}

                                        @if ($errors->has('meta_description'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('meta_description') }}</strong>
                    			         </span>
                                        @endif
                                    </div>
                                </div><!-- end row -->



                                <div class="form-group row">

                                    <div class="col-md-2">
                                        {{Form::label('FB Client', 'FB Client ID', array('class' => ' control-label'))}}

                                        {{Form::text('fb_client_id',$value=$data->fb_client_id,['class'=>'form-control','placeholder'=>' '])}}

                                        @if ($errors->has('fb_client_id'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('fb_client_id') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        {{Form::label('FB Secret', 'FB Client Secret', array('class' => ' control-label'))}}

                                        {{Form::text('fb_client_secret',$value=$data->fb_client_secret,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('fb_client_secret'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('fb_client_secret') }}</strong>
                    			         </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        {{Form::label('FB Redirect', 'FB Redirect', array('class' => ' control-label'))}}

                                        {{Form::text('fb_redirect',$value=$data->fb_redirect,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('fb_redirect'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('fb_redirect') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        {{Form::label('Google Client', 'Google Client Id', array('class' => ' control-label'))}}

                                        {{Form::text('google_client_id',$value=$data->google_client_id,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('google_client_id'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('google_client_id') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        {{Form::label('Google Secret', 'Google Client Secret', array('class' => ' control-label'))}}

                                        {{Form::text('google_client_secret',$value=$data->google_client_secret,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('google_client_secret'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('google_client_secret') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                    <div class="col-md-2">
                                        {{Form::label('Google Redirect', 'Google Redirect', array('class' => ' control-label'))}}

                                        {{Form::text('google_redirect',$value=$data->google_redirect,['class'=>'form-control','placeholder'=>''])}}

                                        @if ($errors->has('google_redirect'))
                                            <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('google_redirect') }}</strong>
                    			         </span>
                                        @endif
                                    </div>

                                </div> <!-- end row -->

                            </div>
                        </div>

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
@endsection

@section('script')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '.textarea',
            menubar: false,
            theme: 'modern',
            plugins: 'image code link lists textcolor imagetools colorpicker ',
            browser_spellcheck: true,
            toolbar1: 'formatselect | bold italic strikethrough | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            // enable title field in the Image dialog
            image_title: true,
            setup: function (ed) {
                ed.on('keyup', function (e) {
                    var count = CountCharacters();
                    document.getElementById("character_count").innerHTML = "Characters: " + count;
                });
            }
        });
    </script>




    <script type="text/javascript">

        $('#currency').on('change',function(){
            var currency_code = $(this).find(':selected').data('id');
            $('#currency_code').val(currency_code);
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