
<table class="table table-striped table-hover table-bordered center_table" id="my_table">
    <thead>
    <tr class="">
        <th width="4">SL.</th>
        <th>Hospital</th>
        <th>Day</th>
        <th>Time Slot</th>
        <th>Fee</th>

    </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    @forelse($doctor->doctorSchedules as $doctorSchedule)
        <tr>
            <td>{{$i++}}</td>
            <td>  <input type="radio"  name="schedule_id" value="{{$doctorSchedule->id}}" data-price="{{$doctorSchedule->fee_after_discount}}" class="test" id="schedule_{{$doctorSchedule->id}}">  <label for="schedule_{{$doctorSchedule->id}}"> {{$doctorSchedule->hospital->name}}</label></td>
            <td>
                @foreach(json_decode($doctorSchedule->available_day) as $day)
                     <label><i class="icofont icofont-rounded-right"></i> {{$day}}</label> <br>
                    @endforeach
                {{--{{$doctorSchedule->doctorAvailableDay}}--}}
            </td>
            <td>{{date('h:i:s a', strtotime($doctorSchedule->available_from))}} To {{date('h:i:s a', strtotime($doctorSchedule->available_to))}}</td>
            <td> {{$doctorSchedule->fee_after_discount}} </td>

        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center"> No Data Found! </td>
        </tr>
    @endforelse
    </tbody>
</table>
<br>
<div class="row justify-content">

    <div class="col-4">
        {{Form::textArea('note',$value=old('note'), ['class' => 'form-control','rows'=>'9','placeholder'=>'Special Notes','required'=>false])}}
    </div>
    <div class="col-8">
        <table class="table table-striped table-hover table-bordered center_table">
            <thead>
            <tr class="">
                <th>Amount</th>
                <th><input type="number" name="amount" value="0" id="amount" required readonly class="form-control" min="1" step="any"></th>
            </tr>
            <tr class="">
                <th>Discount (-)</th>
                <th><input type="number" name="discount" value="0" id="discount"  required class="form-control" min="0" step="any"></th>
            </tr>
            <tr class="">
                <th>Service Charge (+)</th>
                <th><input type="number" name="service_charge" value="{{$setting->appointment_service_charge}}" readonly id="serviceCharge" required class="form-control" min="0" step="any"></th>
            </tr>
            <tr class="">
                <th>Total Amount</th>
                <th><input type="number" name="total_amount" value="0" id="totalAmount" required readonly class="form-control" min="1" step="any"></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    // calculate amount -----------
    var amountServiceCharge="{{$setting->appointment_service_charge}}";

$('.test').on('click',function () {
    var amount=0;
    var discount=0;
    var serviceCharge=amountServiceCharge;
    var totalAmount=0;
   $('.test').each(function () {
       if ($(this).is(':checked')){
           amount+=Number($(this).attr('data-price'))
       }
   })
    $('#amount').val(amount);
    $('#discount').val(discount);
    $('#serviceCharge').val(serviceCharge);
//    totalAmount=amount-Number($('#discount').val())
//    totalAmount+=Number($('#serviceCharge').val())
    $('#totalAmount').val(amount+Number(serviceCharge));
})

// Discount Calculation ---------
$('#discount').on('keyup',function () {
    var amount=$('#amount').val();
    var discount=$('#discount').val();
    var serviceCharge= $('#serviceCharge').val();

    totalAmount=amount-Number(discount)
    totalAmount+=Number(serviceCharge)
    $('#totalAmount').val(totalAmount);
})


$('#serviceCharge').on('keyup',function () {
    var amount=$('#amount').val();
    var discount=$('#discount').val();
    var serviceCharge= $('#serviceCharge').val();

    totalAmount=amount-Number(discount)
    totalAmount+=Number(serviceCharge)
    $('#totalAmount').val(totalAmount);
})

</script>
