@extends('layouts.template')

@section('content')


<div class="panel panel-default panel-service">
    <div class="container">
        <div class="header-top">
            <div class="col title">
                <div class="text-center">
                    <h1 class="space-title">THIS IS POOL SERVICE</h1>
                    <h3 class="space-title">YOUR ONE STOP FOR ALL THINGS POOLS</h3>
                    <div class="text-center">
                            <button type="button" class="btn btn-default">CREATE ACCOUNT</button>
                            <space />
                            <button type="button" class="btn btn-default">LEARN MORE</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col title">
                <div class="text-center">
                    <h1 class="space-title">WHAT WE DO</h1>
                    <p>WE SERVICE THE INDUSTRY THAT SERVICES POOLS</p>
                </div>
            </div>
        </div>
        <div class="row row-eq-height">
            <div class="col-xs-12 col-lg-4 col-md-4  col-sm-12 space-our item">
                <div class="col">
                    <div class="panel">
                        <div class="text-center">
                            <figure><img class="img-circle" src="images/weekly-service.png" alt="weekly-service"></figure>
                            <h2 class="space-title"><span class="text-color-deep"><span class="text-color-deep">Weekly</span> <span class="text-color-water">Service</span></span></h2>
                        </div>
                        <div class="text-center">
                            <p class="text">Sign up for weekly service today!</p>
                        </div>
                        <div class="text-center">
                            <p class="text">Whether salt water or chlorine, we can help you find an technician to regularly clean and maintain your pool.</p>                            
                            
                        </div>
                        <div class="text-center">
                                <a href="user-regis-service" type="button" class="btn btn-default">GET SERVICE</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-4 col-md-4  col-sm-12 space-our item">
                <div class="col">
                    <div class="panel">
                        <div class="text-center">
                            <figure><img class="img-circle" src="images/pool-repair.png" alt="weekly-service"></figure>
                            <h2 class="space-title"><span class="text-color-deep"><span class="text-color-deep">Pool</span> <span class="text-color-water">Repair</span></span></h2>
                        </div>
                        <div class="text-center">
                            <p class="text">Got a broken pool hot tub?</p>
                        </div>
                        <div class="text-center">
                            <p class="text">We can help you find an experienced technician to assess repair needed and advise on how best to proceed.</p>
                        </div>
                        <div class="text-center">
                                <a href="user-regis-service" type="button" class="btn btn-default">GET SERVICE</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-4 col-md-4  col-sm-12 space-our item">
                <div class="col">
                    <div class="panel">
                        <div class="text-center">
                            <figure><img class="img-circle" src="images/deep-cleaning.png" alt="weekly-service"></figure>
                            <h2 class="space-title"><span class="text-color-deep"><span class="text-color-deep">Deep</span> <span class="text-color-water">Cleaning</span></span></h2>
                        </div>
                        <div class="text-center">
                            <p class="text">Restore your pool' original beauty.</p>
                        </div>
                        <div class="text-center">
                            <p class="text">We offer one time service for those times when all your pool really needs is a good, deepscrub.</p>
                        </div>
                        <div class="text-center">
                                <a href="{{route('user-regis-service')}}" type="button" class="btn btn-default">GET SERVICE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


            