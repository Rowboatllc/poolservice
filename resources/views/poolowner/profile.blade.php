<div class="poolowner_profile">
    <div class="row">
        <div class="col-md-3 text-right">
            <div class="fieldset">
                <img class="img_profile" data-selectfile=".form_upload .avatar" path="{{ config('app.url').'../storage/app/' }}" src="{{ config('app.url').'../storage/app/'.$profile->avatar }}" width="100px" height="auto" />
                <div class="form_upload">
                    <form id="form_upload" name="form_upload" action="{{ route('ajax-upload-file') }}" enctype="multipart/form-data" method="POST" 
                          onsubmit="return ajaxUploadFile.submit(this, {'onComplete': function () {
                                          ajaxUploadFile.resetUpload('#form_upload', afterUploadedImage)
                                      }})">
                        {{ csrf_field() }}
                        <input type="file" class="avatar no_display" name="avatar" />
                    </form>
                </div>
                <span class="glyphicon glyphicon-pencil upload-imagefieldset icon badge"></span>
                <span class="glyphicon glyphicon-floppy-save save-imagefieldset icon badge no_display"></span>
                <span class="glyphicon glyphicon-remove cancel-editfieldset icon badge no_display"></span>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="fieldset" method="POST" action="{{route('poolowner-save-email')}}">
                <div class="col-md-3 text-right col"> <span class="labeltext">Email:</span> </div>
                <div class="col-md-9 col">
                    <div name="email" class="contenteditable" contenteditable="true">{{ $profile->email }}</div>
                    <span class="glyphicon glyphicon-pencil editfieldset icon badge"></span>
                    <span class="glyphicon glyphicon-floppy-save savefieldset icon badge no_display"></span>
                    <span class="glyphicon glyphicon-remove cancel-editfieldset icon badge no_display"></span>
                </div>
            </div>

            <div class="fieldset pwdfieldset" method="POST" action="{{route('poolowner-save-password')}}">
                <div class="col-md-3 text-right col"><span class="labeltext">Password:</span></div>
                <div class="col-md-9 col">
                    <div name="password" class="contenteditable password" contenteditable="true" data-validate="require"></div>
                    <span class="glyphicon glyphicon-pencil editfieldset icon badge"></span>
                    <span class="glyphicon glyphicon-floppy-save save-poolownerfieldset icon badge no_display"></span>
                    <span class="glyphicon glyphicon-remove cancel-editfieldset icon badge no_display"></span>
                </div>
                <div class="cover_change_pwd no_display">
                    <div class="col-md-3 text-right col"><span class="labeltext">New password:</span></div>
                    <div class="col-md-9 col"><div name="new-password" class="contenteditable password" contenteditable="true" data-validate="require"></div></div>

                    <div class="col-md-3 text-right col"><span class="labeltext">Type it again:</span></div>
                    <div class="col-md-9 col"><div name="re-password" class="contenteditable password" contenteditable="true"></div></div>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="fieldset" method="POST" action="{{route('admin-save-poolowner-profile')}}">
                <div class="col-md-3 text-right col"><span class="labeltext">First and last name:</span></div>
                <div class="col-md-9 col">
                    <div name="fullname" class="contenteditable" contenteditable="true" data-validate="require">{{ $profile->fullname }}</div>
                    <span class="glyphicon glyphicon-pencil editfieldset icon badge"></span>
                    <span class="glyphicon glyphicon-floppy-save savefieldset icon badge no_display"></span>
                    <span class="glyphicon glyphicon-remove cancel-editfieldset icon badge no_display"></span>
                </div>
                <div class="col-md-3 text-right col"><span class="labeltext">Address:</span></div><div class="col-md-9 col address"><div name="address" class="contenteditable" contenteditable="true"  data-validate="require">{{ $profile->address }}</div></div>
                <div class="col-md-3 text-right col"><span class="labeltext">city, ST zipcode:</span></div><div class="col-md-9 col">
                    <div name="city" class="contenteditable auto">{{$profile->city}}</div>
                        {{ Form::select('state', ['Arizona' => 'Arizona', 'Los Angeles' => 'Los Angeles', 'California' => 'California', 'New England' => 'New England'], $profile->state, ['class' => 'contenteditable','contenteditable'=>false, 'data-validate'=>'require']) }}
                    <div name="zipcode" class="contenteditable auto" contenteditable="true">{{$profile->zipcode}}</div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>