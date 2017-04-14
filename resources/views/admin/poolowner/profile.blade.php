<div class="poolowner_profile">
    <div class="row">
        <div class="col-md-4 text-right col"> Email: </div><div class="col-md-8 col">  {{ $profile->email }} </div>
        <div class="col-md-4 text-right col"> Fullname: </div><div class="col-md-8 col">  {{ $profile->fullname }} </div>
        <div class="col-md-4 text-right col"> Telephone: </div><div class="col-md-8 col">  {{ $profile->phone }} </div>
        <div class="col-md-4 text-right col"> Address: </div><div class="col-md-8 col">  {{ $profile->address }} </div>
        <div class="col-md-4 text-right col"> City: </div><div class="col-md-8 col">  {{ $profile->city }} </div>
        <div class="col-md-4 text-right col"> Zipcode: </div><div class="col-md-8 col">  {{ $profile->zipcode }} </div>
        <div class="col-md-4 text-right col"> State: </div><div class="col-md-8 col">  {{ $profile->state }} </div>
        <div class="col-md-4 text-right col"> Avatar: </div><div class="col-md-8 col">  <img src="{{ config('app.url').'../storage/app/public/'.$profile->avatar }}" </div>
    </div>
    <div class="text-right">
        <button class="btn btn-default" data-toggle="modal" data-target=".editProfileModal">Edit Profile</button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade editProfileModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Profile</h4>
      </div>
      <div class="modal-body">
        
        <form action="{{ route('admin-poolowner-profile') }}" method="POST" />
            <span>
                email : {{ $profile->email }}
            </span>
            {{ Form::text('fullname', $profile->fullname, array_merge(['class' => 'form-control', 'placeholder'=>'fullname'], [])) }}
            {{ Form::text('address', $profile->address, array_merge(['class' => 'form-control', 'placeholder'=>'address'], [])) }}
            {{ Form::text('city', $profile->city, array_merge(['class' => 'form-control', 'placeholder'=>'city'], [])) }}
            {{ Form::text('zipcode', $profile->zipcode, array_merge(['class' => 'form-control', 'placeholder'=>'zipcode'], [])) }}
            {{ Form::text('phone', $profile->phone, array_merge(['class' => 'form-control', 'placeholder'=>'phone'], [])) }}
            {{ Form::select('state', $profile->codes, $profile->zipcode, array_merge(['class' => 'form-control', 'placeholder'=>'phone'], [])) }}
            <image class="avatar" src="" />
            <!--<span class="glyphicon glyphicon-ok save_form"></span>-->
            <div class="text-right">
                <button type="submit" class="btn btn-primary save_form">Save</button>
                <button class="btn btn-default cancel_form">Cancel</button>
            </div>
        </form>
        <form id="form_upload" name="form_upload" action="{{ route('upload-avatar') }}" enctype="multipart/form-data" method="POST" 
              onsubmit="return ajaxUploadFile.submit(this, {'onStart' : function(){}, 'onComplete' : function(){ ajaxUploadFile.resetUpload('#form_upload')} })">
                  <input type="file" name="avatar" class="input-avatar" />
                  <button type="submit"><span class="glyphicon glyphicon-upload" aria-hidden="true" type=></span></button>
        </form>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>