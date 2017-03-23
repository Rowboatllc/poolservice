@extends('layouts.admin.template')

@section('content')

<div class="panel panel-default panel-transparent">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <form class="form-page" role="form" method="POST" action="{{ route('admin-page') }}">
                        {{ csrf_field() }}
                        @if(Session::has('success'))
                            <div class="alert alert-success">Update success !!!</div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-fail">Update failed !!!</div>
                        @endif
                        <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
                            <label for="alias">Select Page:</label>
                            <select class="form-control m-bot15" name="alias">
                                @if ($pages->count())
                                    @foreach($pages as $page)
                                        {{-- <option value="{{ $page->alias }}" {{ $selectedRole == $role->id ? 'selected="selected"' : '' }}>{{ $role->name }}</option> --}}
                                        <option value="{{ $page->alias }}" >{{ $page->alias }}</option>    
                                    @endforeach                                    
                                @endif
                            </select>     
                        </div>
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">Tittle:</label>
                            <input type="text" class="form-control" name="title">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif                    
                        </div>
                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content">Content :</label>
                            <input type="text" class="form-control" name="content" >
                            @if ($errors->has('content'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif     
                        </div>
                        <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }} keywords">
                            <label for="keywords">Keywords :</label><th style="width:10px">
                            <div class="form-group-keywords" id="addRowPage">
                                <div class="form-group has-feedback">
                                    <input type="text" class="form-control" name="keywords[]" >
                                    <span class="glyphicon-remove-page glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <i class="pull-right fa fa-plus add-btn-page" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control" name="description" >
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif     
                        </div>
                        <div  class="text-right"><button type="submit" class="btn btn_primary">Save</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.glyphicon-remove-page', function (e) {
        var $this = $(this);
        $this.parent().remove();  
    });
    $(document).on('click', '.add-btn-page', function (e) {
        var tempTr = '<div class="form-group has-feedback">'+
                            '<input type="text" class="form-control" name="keywords[]" >'+
                            '<span class="glyphicon-remove-page glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>'+
                        '</div>';
        $("#addRowPage").append(tempTr)
    });

</script>
@endsection