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
                <span class="glyphicon glyphicon-pencil upload-imagefieldset icon badge">&nbsp;</span>
                <span class="glyphicon glyphicon-floppy-save save-imagefieldset icon badge no_display">&nbsp;</span>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="fieldset" method="POST" action="{{route('admin-save-account')}}">
                <div class="col-md-3 text-right col"> Email: </div>
                <div class="col-md-9 col">
                    <span name="email" class="contenteditable" contenteditable="true">{{ $profile->email }}</span>
                    <span class="glyphicon glyphicon-pencil editfieldset icon badge">&nbsp;</span>
                    <span class="glyphicon glyphicon-floppy-save savefieldset icon badge no_display">&nbsp;</span>
                </div>
                <div class="col-md-3 text-right col"> Password: </div><div class="col-md-9 col"><span name="password" class="contenteditable" contenteditable="true"></span></div>
                <div class="clearfix"></div>
            </div>

            <div class="fieldset" method="POST" action="{{route('admin-save-poolowner-profile')}}">
                <div class="col-md-3 text-right col"> First and last name: </div>
                <div class="col-md-9 col">
                    <span name="fullname" class="contenteditable" contenteditable="true">{{ $profile->fullname }}</span>
                    <span class="glyphicon glyphicon-pencil editfieldset icon badge">&nbsp;</span>
                    <span class="glyphicon glyphicon-floppy-save savefieldset icon badge no_display">&nbsp;</span>
                </div>
                <div class="col-md-3 text-right col"> Address: </div><div class="col-md-9 col address"><span name="address" class="contenteditable" contenteditable="true">{{ $profile->address }}</span></div>
                <div class="col-md-3 text-right col"> city, ST zipcode: </div><div class="col-md-9 col">
                    <span name="city" class="contenteditable" contenteditable="true">{{$profile->city}}</span>
                    <span name="state" class="contenteditable" contenteditable="true">{{$profile->state}}</span>
                    <span name="zipcode" class="contenteditable" contenteditable="true">{{$profile->zipcode}}</span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>