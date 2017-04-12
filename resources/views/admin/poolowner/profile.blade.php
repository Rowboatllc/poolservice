<div class="poolowner_profile">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target=".editProfileModal">Edit Profile</button>
    <div class="row">
        <div class="col-md-3 text-right"> Email: </div><div class="col-md-9">  {{ $profile->email }} </div>
        <div class="col-md-3 text-right"> Fullname: </div><div class="col-md-9">  {{ $profile->fullname }} </div>
        <div class="col-md-3 text-right"> Telephone: </div><div class="col-md-9">  {{ $profile->phone }} </div>
        <div class="col-md-3 text-right"> Address: </div><div class="col-md-9">  {{ $profile->address }} </div>
        <div class="col-md-3 text-right"> City: </div><div class="col-md-9">  {{ $profile->city }} </div>
        <div class="col-md-3 text-right"> Zipcode: </div><div class="col-md-9">  {{ $profile->zipcode }} </div>
        <div class="col-md-3 text-right"> State: </div><div class="col-md-9">  {{ $profile->state }} </div>
        <div class="col-md-3 text-right"> Avatar: </div><div class="col-md-9">  <img src="{{ config('app.url').'../storage/app/public/'.$profile->avatar }}" </div>
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
        
        <form action="{{ route('admin-poolowner-profile') }}" method="POST" style="width:50%; margin:auto" />
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
            <span class="glyphicon glyphicon-ok save_form"></span>
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