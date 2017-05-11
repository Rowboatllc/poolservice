<div class="box-body table-responsive no-padding my-pool-service-company" style='overflow:visible;'>
    <table class="table table-hover list-company">
        <tr>
            <th><a style='cursor:pointer;'>Pool Service Company</a></th>
            <th><a style='cursor:pointer;'>Service availability</a></th>
            <th><a style='cursor:pointer;'>Pool Service Rating</a></th>
            <th><a style='cursor:pointer;'></a></th>
        </tr>
        @foreach ($companys as $company)
            <tr class="item-company {{ isset($company_select)&& $company_select->id!=$company->id ? 'no_display' : ''}}">	
                <td valign="middle">
                    <img class="logo" src='{{$company->logo}}' width='100' /> {{$company->name}}
                    <input class="company_id" type="hidden" value="{{$company->id}}">
                </td>
                <td valign="middle">
                    @if(isset($company->date_available))
                        Every {{date('l', strtotime($company->date_available))}} starting {{convertDateAvailable($company->date_available)}}
                    @else
                        Every day of the week.
                    @endif
                </td>
                <td valign="middle"><span class="stars">{{$company->point}}</span> <span>({{$company->count}})</span></td>
                <td valign="middle btn-list">
                    <a title="{{ route('select-company', [$company->id]) }}" type="button" class="btn btn-primary btn-choose {{ !isset($company_select) ? '' : 'no_display'}}">Choose</a>
                    <a type="button" class="btn btn-primary btn-choose-start {{ isset($company_select) ? '' : 'no_display'}}"  data-toggle="modal" data-target="#startModal">Rate</a>
                    <a title="{{ route('select-new-company', [$company->id]) }}"type="button" class="btn btn-primary btn-choose-new {{ isset($company_select) ? '' : 'no_display'}}">Choose a new </a>  
                </td>
            </tr>
        @endforeach
    </table>

   
</div>
<div id="startModal" class="modal fade my-pool-service-company rating" role="dialog">
    <form role="form" action="{{route('rating-company')}}" method="post" id="form-rating-company">
    {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Rating company</h4>
                </div>
                <div class="modal-body">
                    <div class="row" id="post-review-box">
                        <div class="col-md-12">
                            <div class="text-center">
                                <input id="company_id" name="company_id" type="hidden" value="{{$company_select->id or 0}}">
                                <input id="company_point" name="company_point" type="text" class="rating" value="{{$point or 0}}" data-size="lg" title="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save-rating">Save changes</button>
                </div>
            </div>

        </div>
    </form>
</div>
