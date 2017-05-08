<div class="box-body no-padding technician-professionnal-service content-block">
    <div class="text-right"><span class="btn btn-primary new-technician new-item" data-toggle="modal" data-target=".technician-professionnal-serviceModal">Add new pool service professional</span></div>
    @if (count($technicians) == 0)
    You currently have no service technician listed in your account
    @else
    <div class="table-responsive" data-totalpage="{{ceil($technicians->total()/$technicians->perPage())}}" data-page="{{$technicians->currentPage()}}" data-url="{{ route('dashboard-company-list-technician') }}" >
        <table class="table table-hover table-list" data-getitemurl="{{ route('dashboard-company-get-technician') }}" data-updateurl="{{ route('dashboard-company-save-technician') }}" data-removeurl="{{ route('dashboard-company-remove-technician') }}" >
            <tr>
                <th width="70px"></th>
                <th width="30%"><span data-orderfield="fullname">Name</span></th>
                <th width="20%"><span data-orderfield="phone">Mobile phone</span></th>
                <th width="30%"><span data-orderfield="email">Email address</span></th>
                <th></th>
            </tr>
            @foreach ($technicians as $technician)
            <tr>
                <td>
                    <span class="fa fa-check-circle fa-6 status {{$technician->status}}" aria-hidden="true"></span>
                    <span class="avatar" style="background-image: url({{ config('app.url').'storage/app/'.$technician->avatar }})"></span>
                </td>
                <td>{{$technician->fullname}}</td>
                <td>{{$technician->phone}}</td>
                <td>{{$technician->email}}</td>
                <td>
                    <span class="glyphicon glyphicon-pencil icon edit-item-list" data-id="{{$technician->id}}"></span> | 
                    <span class="glyphicon glyphicon-trash icon text-danger remove-item-list" data-id="{{$technician->id}}"></span>
                </td>
            </tr>
            @endforeach
        </table>
        <ul class="pagination"></ul>
        <script class="rowtpl" type="text/x-jquery-tmpl">
            <tr>
                <td>
                    <span class="fa fa-check-circle fa-6 status ${status}" aria-hidden="true"></span>
                    <span class="avatar" style="background-image: url({{ config('app.url').'storage/app/' }}${avatar})"></span>
                </td>
                <td>${fullname}</td>
                <td>${phone}</td>
                <td>${email}</td>
                <td>
                    <span class="glyphicon glyphicon-pencil icon edit-item-list" data-id="${id}"></span> | 
                    <span class="glyphicon glyphicon-trash icon text-danger remove-item-list" data-id="${id}"></span>
                </td>
            </tr>
        </script>
    </div>
    @endif

    <div class="modal fade technician-professionnal-serviceModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" data-dismiss="modal">&times;</span>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img class="technician-img" alt="Upload a photo" name="avatar" path="{{ config('app.url').'storage/app/' }}" src="" />
                    </div>
                    <form name="form_upload" class="form_technician-avatar"  action="{{ route('ajax-upload-an-image', ['uploads', 'file-avatar']) }}" enctype="multipart/form-data" method="POST" 
                        onsubmit="return ajaxUploadFile.submit(this, {'onComplete': function () { ajaxUploadFile.resetUpload('.form_technician-avatar', afterUploadedTechnicianAvatar) }})" >
                        {{ csrf_field() }}
                        <label><input type="file" class="avatar" name="file-avatar" onchange="jQuery(this).parents('form').submit()" />Upload a photo</label>
                    </form>
                    <form action="{{ route('dashboard-company-save-technician') }}" method="POST" onsubmit="return false">
                        <div class="form-group checkbox">
                            <label><input name="is_owner" type="checkbox" value="1">I am a pool service professional</label>
                            <span class="glyphicon glyphicon-floppy-save saveform-fieldset icon badge no_display"></span>
                        </div>
                        <div class="form-group">
                            <input name="fullname" type="text" class="form-control" placeholder="first and last name" data-validate="require" />
                            <input name="phone" type="text" class="form-control" placeholder="mobile phone" data-validate="require|number" />
                            <input name="email" type="text" class="form-control" placeholder="email address"  data-validate="require|email" />
                            <input type="hidden" name="company_id" value="{{$technician->company_id or 0}}" />
                            <input type="hidden" name="id" />
                            <input type="hidden" name="avatar" />
                        </div>
                        <div class="text-center">
                            <span class="btn btn-primary" data-dismiss="modal">Cancel</span>
                            <span class="btn btn-primary save-techinician save-item">Save</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ config('app.url') }}js/lib/jquery.tmpl.js" ></script>