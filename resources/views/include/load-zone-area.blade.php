
@if(count($areas)>0)

    {!! Form::select('zone_area_id',$areas,[], ['placeholder' => '--Select Area--','class' => 'form-control','required'=>true]) !!}

    @if ($errors->has('zone_area_id'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('zone_area_id') }}</strong>
        </span>
    @endif

@else

    {!! Form::select('zone_area_id',[],[], ['placeholder' => 'No Area','class' => 'form-control','required'=>false]) !!}

    @if ($errors->has('zone_area_id'))
        <span class="help-block">
        <strong class="text-danger">{{ $errors->first('zone_area_id') }}</strong>
    </span>
    @endif

@endif

