@extends('layouts.admin.template')

@section('content')

<div class="panel panel-default panel-transparent">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                            <ul class="nav nav-tabs">

                                <li class="{{ !$errors->has('page')||$errors->first('page')=='template' ? ' active' : '' }}"><a href="#template" data-toggle="tab">Template</a></li>

                                <li class="{{ $errors->first('page')=='home' ? ' active' : '' }}"><a href="#home" data-toggle="tab">Home</a></li>

                                <li class="{{ $errors->first('page')=='contact' ? ' active' : '' }}"><a href="#contact" data-toggle="tab">Contact</a></li>

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
                            
                            <div class="tab-pane fade {{ !$errors->has('page')||$errors->first('page')=='template' ? ' in active' : '' }}" id="template">@include('admin.options.template')</div>

                            <div class="tab-pane fade {{ $errors->first('page')=='home' ? ' in active' : '' }}" id="home">@include('admin.options.home')</div>

                            <div class="tab-pane fade {{ $errors->first('page')=='contact' ? ' in active' : '' }}" id="contact">@include('admin.options.contact')</div>
                                 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection