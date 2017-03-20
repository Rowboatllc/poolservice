@extends('layouts.template')

@section('head')
    <meta name="description" content="FIND AN EXPERIENCED TECHNICIAN FOR ALL OF YOUR POOL SERVICE NEEDS">
    <meta name="keywords" content="POOL, POOLSERVICE, HOME">
@endsection

@section('content')
<div class="panel panel-default panel-service">
    <div class="container">
        <div class="row">
            <div class="col title">
                <div class="text-center">
                    <h1 class="space-title">{{$title}}</h1>
                    {{$content}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


            