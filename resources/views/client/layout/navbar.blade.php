<nav class="navbar navbar-two navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-2 col-md-3">
                <a class="navbar-brand" href="{{url('/')}}">
                    <img src="{{asset('/client/')}}/assets/img/logo/logo.png" alt="logo">
                </a>
            </div>

            <div class="col-12 col-lg-8 col-md-6">
                <div class="navbar-toggle-btn">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('/#about')}}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('/#department')}}">Download App</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('/#service')}}">Service</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('/#gallery')}}">Gallery</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="#price">Price</a></li> -->
                        <li class="nav-item"><a class="nav-link" href="{{url('/#contact')}}">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-12 col-lg-2 col-md-3 text-right">
                <a href="#appointment" class="appointment-btn">Appointment</a>
            </div>
        </div>
    </div>
</nav>