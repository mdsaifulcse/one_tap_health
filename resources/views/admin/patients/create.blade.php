@extends('admin.layout.app')
@section('title')
    Create new Patient | Patient
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
    </style>
    @endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Create new Patient </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.patients.index')}}" class="btn btn-info btn-sm"  title="Hospital List here"><i class="icofont icofont-list"></i> Patient List</a>
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
                        {!! Form::open(array('route' => 'admin.patients.store','class'=>'','files'=>true)) !!}

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

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Patient Name <sup class="text-danger">*</sup> </label>
                                        <div class="col-9">
                                            <input type="text" name="name" value="{{old('name')}}" required autocomplete="off" class="form-control" placeholder="Patient Name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('name') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Patient Mobile</label>
                                        <div class="col-9">
                                            <input type="text" name="mobile" value="{{old('mobile')}}" autocomplete="off" class="form-control" placeholder="Patient Mobile">
                                            @if ($errors->has('mobile'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('mobile') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Patient Email</label>
                                        <div class="col-9">
                                            <input type="email" name="email" value="{{old('email')}}" autocomplete="off" class="form-control" placeholder="Patient Email">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('email') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Address <sup class="text-danger">*</sup></label>
                                        <div class="col-md-9">
                                            {{Form::textArea('address',$value=old('address'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Patient Address','required'=>true])}}
                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                                <strong class="text-danger text-center">{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('details', 'Patient Details', array('class' => 'col-md-2 control-label text-right'))}}
                                        <div class="col-md-9">
                                            {{Form::textArea('details',$value=old('details'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Patient Details','required'=>false])}}
                                            @if ($errors->has('details'))
                                                <span class="help-block">
                                                <strong class="text-danger text-center">{{ $errors->first('details') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                <div class="form-group row">

                                    <label class="col-md-2 control-label text-right">&nbsp;</label>
                                    <div class="col-2">
                                        <input type="number" name="age" value="{{old('age')}}" required autocomplete="off" class="form-control" placeholder="Age">
                                        <span>Patient age <sup class="text-danger">*</sup></span>

                                        @if ($errors->has('age'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('age') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="patient_no" value="{{old('patient_no',$patientId)}}" required readonly autocomplete="off" class="form-control">
                                        <span>Patient ID <sup class="text-danger">*</sup></span>

                                        @if ($errors->has('patient_no'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('patient_no') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-2">
                                        {{Form::select('status', [\App\Models\Patient::ACTIVE  => 'Active' , \App\Models\Patient::INACTIVE  => 'Inactive'],[], ['class' => 'form-control'])}}
                                        <span>Status</span>

                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <?php $max=$maxSerial+1; ?>
                                    <div class="col-md-2">
                                        {{Form::number('sequence',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required','readonly'=>true])}}
                                        <span>Sequence</span>
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

@endsection