
<table class="table table-striped table-hover table-bordered center_table" id="my_table">
    <thead>
    <tr class="">
        <th width="4">SL.</th>
        <th>Select</th>
        <th>Price</th>
        <th>Discount</th>

    </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    @forelse($hospitalWiseTests as $hospitalWiseTest)
        <tr>
            <td>{{$i++}}</td>
            <td>  <input type="checkbox"  name="test_id[]" value="{{$hospitalWiseTest->test->id}}" data-price="{{$hospitalWiseTest->price-$hospitalWiseTest->discount}}" class="test" id="test_{{$hospitalWiseTest->test->id}}">  <label for="test_{{$hospitalWiseTest->test->id}}"> {{$hospitalWiseTest->test->title}}</label></td>
            <td>{{$hospitalWiseTest->price}}</td>
            <td>{{$hospitalWiseTest->discount??0}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center"> No Data Found! </td>
        </tr>
    @endforelse
    </tbody>
</table>
<br>
<div class="row justify-content-end">
    <div class="col-7">
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
                <th><input type="number" name="service_charge" value="0" id="serviceCharge" required class="form-control" min="0" step="any"></th>
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
$('.test').on('click',function () {
    var amount=0;
    var discount=0;
    var serviceCharge=0;
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
    $('#totalAmount').val(amount);
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
