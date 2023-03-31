@extends('admin.layout.app')
@section('title')
    Set Test Price | Dashboard
@endsection
@section('style')
    <style>
        .price-title {
            width: 65%;
            float: left;
            margin-right: 8px;
        }
        .price-amount {
            width: 25%;
            float: left;
        }
    </style>
    @endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Set Test Price  </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.hospitals.index')}}" class="btn btn-info btn-sm" title="Test List here"><i class="icofont icofont-list"></i> Hospital List</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-md-10 ">
                    <!-- Form -->
                    {!! Form::open(array('route' => 'admin.set-test-price.store','class'=>'','files'=>true)) !!}
                    <input type="hidden" name="hospital_id" value="{{$hospital->id}}" />

                    <div class="card">
                        <div class="card-header">
                            <h5>Set Test Price For <span class="text-info">Hospital: {{$hospital->name}} , Branch: {{$hospital->branch}} , Address: {{$hospital->address1}}</span></h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                                    <thead>
                                    <tr class="">
                                        <th>Set Price</th>
                                        <th>Test Title</th>
                                        <th>Sub Title</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Third Sub Cat</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; ?>
                                    @forelse($activeTests as $data)
                                        <tr>
                                            <td>
                                                <input type="number" name="test_price[{{$data->id}}]" value="" class="form-control" id="test_price_{{$data->id}}" min="1" max="999999" placeholder="{{$data->title}} price here" readonly="" />
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" class="check" value="{{$data->id}}" id="test_id_{{$data->id}}" onclick="openTestPriceBox({{$data->id}})"  name="test_id[]"/> {{$data->title}}
                                                </label>
                                            </td>
                                            <td>{{$data->sub_title}}</td>
                                            <td>{{$data->testCategory->category_name}}</td>
                                            <td>{{$data->testSubCategory?$data->testSubCategory->sub_category_name:'N/A'}}</td>
                                            <td>{{$data->testThirdCategory?$data->testThirdCategory->third_sub_category:'N/A'}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> No Data Found! </td>
                                        </tr>
                                    @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">

                                <div class="col-10">
                                    <button type="submit" class="btn btn-warning form-footer">Submit</button>

                                </div>
                                <div class="col-2">
                                    <a href="{{url('admin/hospitals')}}" class="btn btn-secondary pull-right">Cancel</a>
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

    <script>
        function openTestPriceBox(testId) {

            var readonlyProp=$('#test_price_'+testId).prop('readonly')

            if(readonlyProp===true){ // make price inbox writable  ----
                $('#test_price_'+testId).prop('readonly',false)
                $('#test_price_'+testId).attr('required',true)
            }else {// make price input readonly  ----
                $('#test_price_'+testId).prop('readonly',true)
                $('#test_price_'+testId).val('')
                $('#test_price_'+testId).attr('required',false)
            }

            //$('#test_price_'+testId).prop('readonly',false)
        }
    </script>

    <!-- Add / Remove Code -->
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 1000; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            //var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="{{asset('images/default/remove-icon.png')}}"/></a></div>'; //New input field html
            var fieldHTML = '<div class="clearfix m-b-10">\n' +
                '\n' +
                '<input class="form-control price-title" min="0" max="999999" step="any" placeholder="Search hospital here" required="" name="price_title[]" type="text">\n' +
                '<input class="form-control price-amount" min="0" max="999999" step="any" placeholder="Test price" required="" name="price[]" type="number">\n' +
                '\n' +
                '\n' +
                '<a href="javascript:void(0);" class="remove_button" title="Delete"><i class="icofont icofont-ui-remove icofont-2x"></i>\n' +
                '</a>\n' +
                '</div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>

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