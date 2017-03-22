@extends('layouts.template')

@section('content')

<div class="panel panel-default">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                @if (!$errors->has('page')||$errors->first('page')=='home')
                                    <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
                                @else
                                   <li><a href="#home" data-toggle="tab">Home</a></li>
                                @endif
                                @if ($errors->first('page')=='contact')
                                    <li class="active"><a href="#contact" data-toggle="tab">Contact</a></li>
                                @else
                                    <li ><a href="#contact" data-toggle="tab">Contact</a></li>
                                @endif
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
                            @if (!$errors->has('page')||$errors->first('page')=='home')
                                <div class="tab-pane fade in active" id="home">@include('admin.home')</div>
                            @else
                                <div class="tab-pane fade" id="home">@include('admin.home')</div>
                            @endif
                            @if ($errors->first('page')=='contact')
                                <div class="tab-pane fade in active" id="contact">@include('admin.contact')</div>
                            @else
                                <div class="tab-pane fade" id="contact">@include('admin.contact')</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection