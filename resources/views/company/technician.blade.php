<div class="box-body table-responsive no-padding technician-professionnal-service">
    <div class="text-right"><button class="btn btn-success new-technician" data-toggle="modal" data-target=".technician-professionnal-serviceModal">Add new pool service professional</button></div>
    @if (count($technicians) == 0)
    You currently have no service technician listed in your account
    @else
    <div class="table-responsive">
        <table class="table table-hover table-list" data-url="{{ route('dashboard-company-list-technician') }}" data-updateurl="{{ route('dashboard-company-save-technician') }}" data-removeurl="{{ route('dashboard-company-remove-technician') }}" >
            <tr>
                <th></th>
                <th></th>
                <th>Name</th>
                <th>Mobile phone</th>
                <th>Email address</th>
                <th></th>
            </tr>
            @foreach ($technicians as $technician)
            <tr>
                <td><span data-cell="img-avatar" data-value="{{ config('app.url').'storage/app/'.$technician->avatar }}" class="avatar" style="background-image: url({{ config('app.url').'storage/app/'.$technician->avatar }})"></span></td>
                <td class="status" data-cell="status">{{$technician->status}}</td>
                <td data-cell="fullname">{{$technician->fullname}}</td>
                <td data-cell="phone">{{$technician->phone}}</td>
                <td data-cell="email">{{$technician->email}}</td>
                <td data-cell="id" data-value="{{$technician->id}}">
                    <span class="glyphicon glyphicon-pencil icon edit-item-list" data-id="{{$technician->id}}"></span> | 
                    <span class="glyphicon glyphicon-trash icon remove-item-list" data-id="{{$technician->id}}"></span>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $technicians->links() }}
        <!--<ul class="pagination"></ul>-->
    </div>
    @endif

    <div class="modal fade technician-professionnal-serviceModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <img class="technician-img" name="img-avatar" path="{{ config('app.url').'storage/app/' }}" src="" />
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
                            <input type="hidden" name="company" value="{{$technician->company_id or 0}}" />
                            <input type="hidden" name="id" />
                            <input type="hidden" name="avatar-path" />
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
<script type="text/javascript" src="{{ config('app.url') }}public/js/lib/jquery.tmpl.js" ></script>

<script class="rowtpl" type="text/x-jquery-tmpl">
    <tr>
        <td data-cell="status" class="status" >${status}</td>
        <td data-cell="fullname">${fullname}</td>
        <td data-cell="phone">${phone}</td>
        <td data-cell="email">${email}</td>
        <td>
            <span data-cell="id" class="glyphicon glyphicon-pencil icon edit-item-list" data-id="${id}"></span> | 
            <span class="glyphicon glyphicon-trash icon remove-item-list" data-id="${id}"></span>
        </td>
    </tr>
</script>
<script class="item-paging-tpl" type="text/x-jquery-tmpl">
    <li><span>${number}</span></li>
</script>