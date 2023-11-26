
@if(count($subCats)>0)

    {!! Form::select('subcategory_id',$subCats,[], ['id'=>'loadThirdSubCategory','placeholder' => '--Select Sub-Category--','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('subcategory_id'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('subcategory_id') }}</strong>
        </span>
    @endif

@else

    {!! Form::select('subcategory_id',[],[], ['id'=>'loadThirdSubCategory','placeholder' => 'No Sub-Category','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('subcategory_id'))
        <span class="help-block">
        <strong class="text-danger">{{ $errors->first('subcategory_id') }}</strong>
    </span>
    @endif

@endif

