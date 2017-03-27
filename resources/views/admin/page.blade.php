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
                            <select class="form-control m-bot15 alias" name="alias">
                                @if ($pages->count())
                                    @foreach($pages as $page)
                                        <option value="{{ $page->alias }}" {{ old('alias',$page['alias']) == $page->alias ? 'selected="selected"' : '' }}>{{ $page->alias }}</option>
                                    @endforeach                                    
                                @endif
                            </select>     
                        </div>
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">Tittle:</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title',$page['title'])}}">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif                    
                        </div>
                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content">Content :</label>
                            <input type="text" class="form-control" name="content" value="{{ old('content',$page['content'])}}">
                            @if ($errors->has('content'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif     
                        </div>
                        <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }}">
                            <label for="keywords">Keywords:</label>
                            <input type="text" class="form-control" name="keywords" value="{{ old('keywords',$page['keywords'])}}">
                            @if ($errors->has('keywords'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('keywords') }}</strong>
                                </span>
                            @endif     
                        </div>
                        {{-- <div class="form-group keywords">
                            <label for="keywords">Keywords :</label><th style="width:10px">
                            <div class="form-group-keywords" id="addRowPage">
                                @if(isset(old('keywords',$page->keywords)[0]))
                                    @foreach(old('keywords',$page->keywords) as $keyword)
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control keyword" name="keywords[]" value="{{$keyword}}">
                                            <span class="glyphicon-remove-page glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group has-feedback {{ $errors->has('keywords') ? ' has-error' : '' }}">
                                        <input type="text" class="form-control keyword" name="keywords[]" >
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group has-feedback">
                                <i class="pull-right fa fa-plus add-btn-page" aria-hidden="true"></i>
                            </div>
                            @if ($errors->has('keywords'))
                                <span class="help-block {{ $errors->has('keywords') ? ' has-error' : '' }}">
                                    <strong>{{ $errors->first('keywords') }}</strong>
                                </span>
                            @endif    
                        </div> --}}
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control" name="description" value="{{ old('description',$page['description'])}}">
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
    /*$(document).on('click', '.glyphicon-remove-page', function (e) {
        var $this = $(this);
        $this.parent().remove();  
    });
    $(document).on('click', '.add-btn-page', function (e) {
        var checkValue = true;
        $(".form-group .keyword").each(function() {
            var $this = $(this);
            if(!$this.val()){
                checkValue = false;
                $this.parent().addClass('has-error');
                return;
            }
            $this.parent().removeClass('has-error');
        });
        if(checkValue){
            var tempTr = '<div class="form-group has-feedback">'+
                            '<input type="text" class="form-control keyword" name="keywords[]" >'+
                            '<span class="glyphicon-remove-page glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>'+
                        '</div>';
            $("#addRowPage").append(tempTr)
        }
    });*/
    $('.alias').on('change', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var alias = this.value;
        $.ajax({
            url:"/api/get-page",
            data: {_token: CSRF_TOKEN,
                    alias: alias},                    
            type: 'POST',
            success:function(page) {
                $('input[name="title"]').val(page.title);
                $('input[name="content"]').val(page.content);
                $('input[name="keywords"]').val(page.keywords);
                $('input[name="description"]').val(page.description);
            }
        });      
        
    })

</script>
@endsection