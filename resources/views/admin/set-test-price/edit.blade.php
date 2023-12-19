@extends('admin.layout.app')
@section('title')
    Update Test Price | Test Price
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
                <h4>Update Test Price  </h4>
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
                    {!! Form::open(array('route' => ['admin.set-test-price.update',$hospital->id],'method'=>'PUT','class'=>'','files'=>true)) !!}
                    <input type="hidden" name="hospital_id" value="{{$hospital->id}}" />

                    <div class="card">
                        <div class="card-header">
                            <h5>Uptate Test Price For <span class="text-info">Hospital: {{$hospital->name}} , Branch: {{$hospital->branch}} , Address: {{$hospital->address1}}</span></h5>
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
                                        <th>Discount</th>
                                        <th>Test Title</th>
                                        <th>Sub Title</th>
                                        <th>Category</th>
                                        {{--<th>Sub Category</th>--}}

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; ?>
                                    @forelse($activeTests as $data)
                                        <tr>
                                            <td width="100px">
                                                <input type="number" name="test_price[{{$data->id}}]" value="{{$data->price}}" {{$data->price>0?'':'readonly'}} class="form-control" id="test_price_{{$data->id}}" min="1" max="999999" placeholder="price for {{$data->title}}"  />
                                                <input type="hidden" value="{{$data->price}}" id="old_test_price_{{$data->id}}">
                                            </td>
                                            <td>
                                                <input type="number" name="test_discount[{{$data->id}}]" class="form-control" value="{{$data->discount}}" {{$data->price>0?'':'readonly'}} id="test_discount_{{$data->id}}"  min="0" max="99999" placeholder="discount for {{$data->title}}" />
                                                <input type="hidden" value="{{$data->discount}}" id="old_test_discount_{{$data->id}}">
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" class="check" value="{{$data->id}}" {{$data->price>0?'checked':''}} id="test_id_{{$data->id}}" onclick="openTestPriceBox({{$data->id}})"  name="test_id[]"/> {{$data->title}}
                                                </label>
                                            </td>
                                            <td>{{$data->sub_title}}</td>
                                            <td>{{$data->testCategory->category_name}}</td>
                                            {{--<td>{{$data->testSubCategory?$data->testSubCategory->sub_category_name:'N/A'}}</td>--}}
                                            {{--<td>{{$data->testThirdCategory?$data->testThirdCategory->third_sub_category:'N/A'}}</td>--}}
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
            if(readonlyProp===true){// make price inbox writable  ----
                $('#test_price_'+testId).prop('readonly',false)
                $('#test_price_'+testId).val($('#old_test_price_'+testId).val())
                $('#test_price_'+testId).attr('required',true)
                $('#test_discount_'+testId).prop('readonly',false)
                $('#test_discount_'+testId).val($('#old_test_discount_'+testId).val())
            }else {// make price input readonly  ----
                $('#test_price_'+testId).prop('readonly',true)
                $('#test_price_'+testId).val('')
                $('#test_price_'+testId).attr('required',false)
                $('#test_discount_'+testId).prop('readonly',true)
                $('#test_discount_'+testId).val(0)
            }

            //$('#test_price_'+testId).prop('readonly',false)
        }
    </script>

@endsection