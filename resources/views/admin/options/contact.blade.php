<div class="panel panel-warning panel-gotadi">
    <div class="panel-heading clickable">
        <h3 class="panel-title text-left">Page</h3>
        <span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span>
    </div>
    <div class="panel-body">
        Page
    </div>
</div>


@if ($errors->first('contact')=='bloc_contact_left')
<div class="panel panel-info panel-gotadi panel-gotadi-default"> 
@else
<div class="panel panel-info panel-gotadi"> 
@endif
    <div class="panel-heading clickable">
        <h3 class="panel-title text-left">Block contact left</h3>
        <span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span>
    </div>
    <div class="panel-body">
        <form class="form-manager-contact" role="form" method="POST" action="{{ route('admin-option-contact') }}">
            {{ csrf_field() }}
            @if(Session::has('success'))
                <div class="alert alert-success">Update success !!!</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-fail">Update failed !!!</div>
            @endif
            <div class="form-group{{ $errors->has('contact_title') ? ' has-error' : '' }}">
                <label for="contact_title">Contact title:</label>
                <input type="text" class="form-control" name="contact_title" value="{{ old('contact_title',$block_contact_left['contact_title'])}}">
                @if ($errors->has('contact_title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('contact_title') }}</strong>
                    </span>
                @endif       
            </div>
            <div class="form-group{{ $errors->has('contact_description') ? ' has-error' : '' }}">
                <label for="contact_description">Contact description:</label>
                <input type="text" class="form-control" name="contact_description" value="{{ old('contact_description',$block_contact_left['contact_description'])}}">
                @if ($errors->has('contact_description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('contact_description') }}</strong>
                    </span>
                @endif                    
            </div>
            <div class="form-group{{ $errors->has('call_title') ? ' has-error' : '' }}">
                <label for="call_title">Call title:</label>
                <input type="text" class="form-control" name="call_title" value="{{ old('call_title',$block_contact_left['call_title'])}}">
                @if ($errors->has('call_title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('call_title') }}</strong>
                    </span>
                @endif     
            </div>
            <div class="form-group{{ $errors->has('call_number') ? ' has-error' : '' }}">
                <label for="call_number">Call number:</label>
                <input type="text" class="form-control" name="call_number" value="{{ old('call_number',$block_contact_left['call_number'])}}">
                @if ($errors->has('call_number'))
                    <span class="help-block">
                        <strong>{{ $errors->first('call_number') }}</strong>
                    </span>
                @endif     
            </div>
            <div class="form-group{{ $errors->has('email_title') ? ' has-error' : '' }}">
                <label for="email_title">Email title:</label>
                <input type="text" class="form-control" name="email_title" value="{{ old('email_title',$block_contact_left['email_title'])}}">
                @if ($errors->has('email_title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email_title') }}</strong>
                    </span>
                @endif     
            </div>
            <div class="form-group{{ $errors->has('email_address') ? ' has-error' : '' }}">
                <label for="email_address">Email address:</label>
                <input type="text" class="form-control" name="email_address" value="{{ old('email_address',$block_contact_left['email_address'])}}">
                @if ($errors->has('email_address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email_address') }}</strong>
                    </span>
                @endif     
            </div>
            <div  class="text-right"><button type="submit" class="btn btn_primary">Save</button></div>
        </form>
    </div>
</div>

<div class="panel panel-warning panel-gotadi">
    <div class="panel-heading clickable">
        <h3 class="panel-title text-left">Block contact right</h3>
        <span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span>
    </div>
    <div class="panel-body">
        Right
    </div>
</div>
