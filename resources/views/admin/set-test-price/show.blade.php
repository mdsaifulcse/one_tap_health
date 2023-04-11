
<div class="modal-header">
    <h4 class="modal-title">Test Price For Details</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="row justify-content-center">
        <div class="col-md-12 ">

            <div class="card">
                <div class="card-header">
                    <h5> Test Price For <span class="text-info">Hospital: {{$hospital->name}} , Branch: {{$hospital->branch}} , Address: {{$hospital->address1}}</span></h5>
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
                                    <td>
                                        <input type="number" name="test_price[{{$data->id}}]" value="{{$data->price}}" readonly class="form-control" id="test_price_{{$data->id}}" min="1" max="999999" placeholder="{{$data->title}} price here"  />
                                    </td>
                                    <td>
                                        <input type="number" name="test_discount[{{$data->id}}]" value="{{$data->discount}}" readonly class="form-control" id="test_discount_{{$data->id}}" min="1" max="999999" placeholder="{{$data->title}} price here"  />
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" class="check" value="{{$data->id}}" {{$data->price>0?'checked':''}} readonly id="test_id_{{$data->id}}" onclick="openTestPriceBox({{$data->id}})"  name="test_id[]"/> {{$data->title}}
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
            </div>
        <!-- end of form -->
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
