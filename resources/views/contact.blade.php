@extends('layouts.template')

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


            