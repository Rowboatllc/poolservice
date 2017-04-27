@extends('layouts.template')

{{-- @section('head')
    <title>{{ $title or 'PoolService' }}</title>
    <meta name="description" content="{{$description}}">
    <meta name="keywords" content="{{$keywords}}">
@endsection --}}

@section('baner')
<div class="header-top baner">
    <div class="col title">
        <div class="text-center">
            <h1 class="space-title baner-title">THIS IS POOL SERVICE</h1>
            <h4 class="space-title baner-description">YOUR ONE STOP FOR ALL THINGS POOLS</h4>
            <div class="space-title text-center">
                    <a href="register/pool-owner-register" type="button" class="btn btn-primary">CREATE POOL OWNER ACCOUNT</a>
                    <a href="register/pool-service-register" type="button" class="btn btn-primary">CREATE POOL SERVICE ACCOUNT</a>
                    <button type="button" class="btn">LEARN MORE</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="panel panel-default panel-service panel-transparent">
    <div class="container">
        <div class="row">
            <div class="col title">
                <div class="text-center">
                    <p class="panel-service-title">WHAT WE DO</p>
                    <p class="panel-service-description">WE SERVICE THE INDUSTRY THAT SERVICES POOLS</p>
                </div>
            </div>
        </div>
        <div class="row row-eq-height">
            <div class="col-xs-12 col-lg-4 col-md-4  col-sm-6 space-our item">
                <div class="col">
                    <div class="panel">
                        <div class="text-center">
                            <figure><img class="img-circle" src="images/weekly-service.png" alt="weekly-service"></figure>
                            <h2 class="space-title"><span>GET SERVICE</span></h2>
                        </div>
                        <div class="text-center">
                            <p class="text">Sign up for weekly service today!</p>
                        </div>
                        <div class="text-center">
                            <p class="text">Whether salt water or chlorine, we can help you find an technician to regularly clean and maintain your pool.</p>                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-4 col-md-4  col-sm-6 space-our item">
                <div class="col">
                    <div class="panel">
                        <div class="text-center">
                            <figure><img class="img-circle" src="images/pool-repair.png" alt="weekly-service"></figure>
                            <h2 class="space-title"><span>GET THE APP</span></h2>
                        </div>
                        <div class="text-center">
                            <p class="text">Got a broken pool hot tub?</p>
                        </div>
                        <div class="text-center">
                            <p class="text">We can help you find an experienced technician to assess repair needed and advise on how best to proceed.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-4 col-md-4  col-sm-6 space-our item">
                <div class="col">
                    <div class="panel">
                        <div class="text-center">
                            <figure><img class="img-circle" src="images/deep-cleaning.png" alt="weekly-service"></figure>
                            <h2 class="space-title"><span >JOIN NETWORK</span></span></h2>
                        </div>
                        <div class="text-center">
                            <p class="text">Restore your pool' original beauty.</p>
                        </div>
                        <div class="text-center">
                            <p class="text">We offer one time service for those times when all your pool really needs is a good, deepscrub.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


            