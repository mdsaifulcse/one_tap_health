@extends('admin.layout.app')
@section('title')
    Tests List
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4> Test List </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.tests.create')}}" class="btn btn-info btn-sm"  title="Create New Test"><i class="icofont icofont-plus"></i> Test</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>All Test List</h5>
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
                                        <th>Title</th>
                                        <th>Sub Title</th>
                                        <th>Category</th>
                                        {{--<th>SubCategory</th>--}}
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; ?>
                                    @forelse($tests as $data)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$data->title}}</td>
                                            <td>{{$data->sub_title}}</td>
                                            <td>{{$data->testCategory->category_name}}</td>
                                            {{--<td>{{$data->testSubCategory?$data->testSubCategory->sub_category_name:''}}</td>--}}
                                            <td>
                                                @if($data->status==\App\Models\Test::ACTIVE)
                                                    <i class="icofont icofont-check-circled icofont-2x text-success"></i> Active
                                                @elseif($data->status==\App\Models\Test::INACTIVE)
                                                    <i class="icofont icofont-ui-close text-danger"></i> Inactive
                                                @endif
                                            </td>
                                            <td>{{$data->created_at->diffForHumans()}}</td>
                                            <td>
                                                {!! Form::open(array('route' => ['admin.tests.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                                <a href="{{route('admin.tests.edit',$data->id) }}" class="btn btn-success btn-sm" title="Click to Edit"><i class="icofont icofont-edit"></i> </a>
                                                <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")' title="Click to Delete"><i class="icofont icofont-trash"></i></button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> No Data Found ! </td>
                                        </tr>
                                    @endforelse


                                    </tbody>
                                </table>
                                {{$tests->links()}}
                            </div>
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


    </script>
@endsection