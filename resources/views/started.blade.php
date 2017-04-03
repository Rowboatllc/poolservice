@extends('layouts.template')

@section('content')  
    <div class="container started">
        <div class="row">
            <div class="col-sm-8">
                <div class="header-content">
                    <div class="header-content-inner text-left">
                        <h2>Welcom to PoolService.com</h2>
                        <p>You just mode getting service for your pool easier everyone involved.</p>
                        <p>Let's get started by finding a pool service professional in your area.</p>                            
                        <a href="/dashboard" class="btn btn-danger">Get Started</a>
                        <br />
                        <br />
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="screen">
                    <img src="/images/started.jpg" >
                </div>
            </div>
        </div>
    </div>
@endsection
