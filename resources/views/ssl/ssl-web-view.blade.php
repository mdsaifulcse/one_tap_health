<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <title>OneTabHealth -- SSl Pay</title>
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('images/logo/favicon-96x96.png')}}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>


<style>
    body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
    }
    h1 {
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }
    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size:20px;
        margin: 0;
    }
    i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
    }
    .success{
         color: #88B04B;;
    }
    .fail_cancel{
        color: red;
    }
    .card {
        background: white;
        padding: 30px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: block;
        margin: 0 auto;
    }
</style>
<body >
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div style="border-radius:200px; height:130px; width:320px; margin:0 auto;">
                    <img src="{{asset('images/logo/logo1.png')}}" class="img img-responsive" style="width: 195px;margin: auto;">
                </div>

                @if($data['status']=='success')

                    <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                        <i class="checkmark">✓</i>
                    </div>
                    <h1 class="success">Success</h1>
                    <p>We have received your Payment <b>TK.{{$data['payment_amount']}}</b><br/> Thank you for your order!</p>

                @elseif($data['status']=='canceled')
                    <div style="border-radius:200px; height:200px; width:200px; margin:0 auto;">
                        <img src=" {{asset('images/logo/failed.png')}}" style="width: 170px;margin: auto;">
                    </div>
                    <h1 class="fail_cancel">Canceled</h1>
                    <p>{{$data['message']}}  </p>

                @elseif($data['status']=='failed')

                    <div style="border-radius:200px; height:200px; width:200px; margin:0 auto;">
                        <img src=" {{asset('images/logo/failed.png')}}" style="width: 170px;margin: auto;">
                    </div>
                    <h1 class="fail_cancel">Failed</h1>
                    <p>{{$data['message']}}</p>

                @else
                    <div style="border-radius:200px; height:200px; width:200px; margin:0 auto;">
                        <img src=" {{asset('images/logo/failed.png')}}" style="width: 170px;margin: auto;">
                    </div>
                    <h1 class="fail_cancel">Try Again</h1>
                    <p>Something Went Wrong, Try Again later ! </p>

                @endif

            </div>
        </div>
    </div>
</div>
</body>
</html>