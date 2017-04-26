<div class="box-body table-responsive no-padding technician-professionnal-service">
    <div class="text-right"><button class="btn btn-success" data-toggle="modal" data-target="#technician-professionnal-serviceModal">Add new pool service professional</button></div>
    @if (count($technicians) == 0)
    You currently have no service technician listed in your account
    @else
    <div class="table-responsive">
        <table class="table table-hover table-list" data-delurl="" data-updateurl="{{ route('dashboard-company-save-technician') }}" data-removeurl="{{ route('dashboard-company-remove-technician') }}" >
            <tr>
                <th></th>
                <th>Name</th>
                <th>Mobile phone</th>
                <th>Email address</th>
                <th></th>
            </tr>
            @foreach ($technicians as $technician)
            <tr>	
                <td class="status">{{$technician->status}}</td>
                <td>{{$technician->fullname}}</td>
                <td>{{$technician->phone}}</td>
                <td>{{$technician->email}}</td>
                <td>
                    <span class="glyphicon glyphicon-pencil icon edit-item-list" data-id="{{$technician->id}}"></span> | 
                    <span class="glyphicon glyphicon-trash icon remove-item-list" data-id="{{$technician->id}}"></span>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    <div class="modal fade" id="technician-professionnal-serviceModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <img class="technician-img" path="{{ config('app.url').'../storage/app/' }}" src="" />
                    <form name="form_upload" class="form_technician-avatar"  action="{{ route('ajax-upload-image', 'uploads') }}" enctype="multipart/form-data" method="POST" onsubmit="return ajaxUploadFile.submit(this, {'onComplete': function () {
                                          ajaxUploadFile.resetUpload('.form_technician-avatar', afterUploadedTechnicianAvatar)
                                      }})" >
                        {{ csrf_field() }}
                        <label><input type="file" class="avatar no_display" name="avatar" onchange="jQuery(this).parents('form').submit()" />Upload a photo</label>
                    </form>
                    <form action="{{ route('dashboard-company-save-technician') }}" method="POST" onsubmit="return false">
                        <div class="form-group checkbox">
                            <label><input name="is_owner" type="checkbox" value="1">I am a pool service professional</label>
                            <span class="glyphicon glyphicon-floppy-save saveform-fieldset icon badge no_display"></span>
                        </div>
                        <div class="form-group">
                            <input name="fullname" type="text" class="form-control" placeholder="first and last name" />
                            <input name="phone" type="text" class="form-control" placeholder="mobile phone" />
                            <input name="email" type="text" class="form-control" placeholder="email address" />
                            <input type="hidden" name="company" value="{{$technician->company_id}}" />
                            <input type="hidden" name="id" />
                            <input type="hidden" name="avatar" />
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-success save-techinician">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>