@extends('layouts.admin.template')
@section('content')

<div class="panel panel-default panel-transparent">
    <div class="container">
        <div class="row">
            <a href="{{ route('admin-poolowner') }}"> Pool owner</a> | 
            <a href="{{ route('admin-poolservice') }}"> Pool service </a> | 
            <a href="{{ route('admin-technican') }}"> Technican </a> | 
            <a href="{{ route('admin-administrator') }}"> Administrator </a> | 
        </div>
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                @if (!$errors->has('page')||$errors->first('page')=='template')
                                    <li class="active"><a href="#template" data-toggle="tab">Template</a></li>
                                @else
                                   <li><a href="#template" data-toggle="tab">Template</a></li>
                                @endif

                                @if ($errors->first('page')=='home')
                                    <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
                                @else
                                   <li><a href="#home" data-toggle="tab">Home</a></li>
                                @endif

                                @if ($errors->first('page')=='contact')
                                    <li class="active"><a href="#contact" data-toggle="tab">Contact</a></li>
                                @else
                                    <li ><a href="#contact" data-toggle="tab">Contact</a></li>
                                @endif
                                    <li ><a href="#option_global" data-toggle="tab">Global</a></li>
                                {{-- <li class="dropdown">
                                    <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#tab4primary" data-toggle="tab">Primary 4</a></li>
                                        <li><a href="#tab5primary" data-toggle="tab">Primary 5</a></li>
                                    </ul>
                                </li> --}}
                            </ul>
                    </div>
                    <div class="panel-body panel-body-manager">
                        <div class="tab-content">
                            @if (!$errors->has('page')||$errors->first('page')=='template')
                                <div class="tab-pane fade in active" id="template">@include('admin.options.template')</div>
                            @else
                                <div class="tab-pane fade" id="template">@include('admin.options.template')</div>
                            @endif

                            @if ($errors->first('page')=='home')
                                <div class="tab-pane fade in active" id="home">@include('admin.options.home')</div>
                            @else
                                <div class="tab-pane fade" id="home">@include('admin.options.home')</div>
                            @endif

                            @if ($errors->first('page')=='contact')
                                <div class="tab-pane fade in active" id="contact">@include('admin.options.contact')</div>
                            @else
                                <div class="tab-pane fade" id="contact">@include('admin.options.contact')</div>
                            @endif
                            <div class="tab-pane fade" id="option_global">@include('admin.options.optioncustom')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection