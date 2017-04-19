@extends('layouts.admin.template')
@section('content')

<div class="panel panel-default panel-transparent">
    <div class="container">
        <div class="row">
            <a href="{{ route('admin-poolowner') }}"> Pool owner</a> | 
            <a href="{{ route('admin-poolservice') }}"> Pool service </a> | 
            <a href="{{ route('admin-technician') }}"> Technican </a> | 
            <a href="{{ route('admin-administrator') }}"> Administrator </a> | 
        </div>
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="{{ !$errors->has('page')||$errors->first('page')=='template' ? ' active' : '' }}"><a href="#template" data-toggle="tab">Template</a></li>

                                <li class="{{ $errors->first('page')=='home' ? ' active' : '' }}"><a href="#home" data-toggle="tab">Home</a></li>

                                <li class="{{ $errors->first('page')=='contact' ? ' active' : '' }}"><a href="#contact" data-toggle="tab">Contact</a></li>

                                <li ><a href="#option_global" data-toggle="tab">Global</a></li>

                            </ul>
                    </div>
                    <div class="panel-body panel-body-manager">
                        <div class="tab-content">
                            <div class="tab-pane fade {{ !$errors->has('page')||$errors->first('page')=='template' ? ' in active' : '' }}" id="template">@include('admin.options.template')</div>

                            <div class="tab-pane fade {{ $errors->first('page')=='home' ? ' in active' : '' }}" id="home">@include('admin.options.home')</div>

                            <div class="tab-pane fade {{ $errors->first('page')=='contact' ? ' in active' : '' }}" id="contact">@include('admin.options.contact')</div>
                                 
                            <div class="tab-pane fade" id="option_global">@include('admin.options.optioncustom')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection