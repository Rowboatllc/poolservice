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
            <div class="row option_panel" data-group="global" data-saveurl="{{ route('save-option') }}" data-removeurl="{{ route('remove-option') }}" >
                <div class="cover_an_option" style="display:none">
                    <div class="an_option" data-key=""  >
                        {{ csrf_field() }}
                        <input type="text" name="option_label" placeholder="label" value="" />
                        <input type="text" name="option_key" placeholder="name" value=""  />
                        <input type="text" name="option_value" placeholder="value" value="" />
                        <span class="glyphicon glyphicon-remove remove_option"></span>
                        <span class="glyphicon glyphicon-ok save_option"></span>
                    </div>
                    <div class="a_group" data-key=""  >
                        <input type="text" name="group" placeholder="group name" value="" />
                        <span class="glyphicon glyphicon-remove remove_group"></span>
                        <span class="glyphicon glyphicon-ok save_group"></span>
                        <div>
                            <span class="glyphicon glyphicon-plus add_new">newOption</span>
                        </div>
                    </div>
                </div>
                @foreach ($options as $option)
                <div class="an_option" data-key="{{ $option->mykey }}">
                    <input type="text" name="option_label" placeholder="label" value="{{ $option->value['label'] }}" />
                    <input type="text" name="option_key" placeholder="name" value="{{ $option->mykey }}"  />
                    <input type="text" name="option_value" placeholder="value" value="{{ $option->value['value'] }}" />
                    <span class="glyphicon glyphicon-remove remove_option"></span>
                    <span class="glyphicon glyphicon-ok save_option"></span>
                </div>
                @endforeach
                <div>
                    <span class="glyphicon glyphicon-plus add_new_group">newGroup</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection