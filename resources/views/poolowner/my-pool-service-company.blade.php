<div class="box-body table-responsive no-padding my-pool-service-company" style='overflow:visible;'>
    <table class="table table-hover list-company">
        <tr>
            <th><a style='cursor:pointer;'>Pool Service Company</a></th>
            <th><a style='cursor:pointer;'>Service availability</a></th>
            <th><a style='cursor:pointer;'>Pool Service Rating</a></th>
            <th><a style='cursor:pointer;'></a></th>
        </tr>
        @foreach ($companys as $company)
            <tr class="item-company">	
                <td valign="middle"><img class="logo" src='{{$company->logo}}' width='100' /> {{$company->name}}</td>
                <td valign="middle">every Tuesday starting March 28,2017</td>
                <td valign="middle"><span class="stars">{{$company->point}}</span> <span>({{$company->count}})</span></td>
                <td valign="middle btn-list">
                    {{-- @if($company_id==0)
                        <a href="{{ route('select-company', [$company->id]) }}" type="button" class="btn btn-primary btn-choose">Choose</a>
                    @else
                        <a href="{{ route('select-new-company', [$company->id]) }}" type="button" class="btn btn-primary btn-choose-new">Choose a new </a>                        
                        <button  class="btn btn-primary btn-choose-new">Choose a new </button>                        
                    @endif --}}

                    <a title="{{ route('select-company', [$company->id]) }}" type="button" class="btn btn-primary btn-choose {{ $company_id==0 ? '' : 'no_display'}}">Choose</a>
                    <a type="button" class="btn btn-primary btn-choose-start {{ $company_id!=0 ? '' : 'no_display'}}"  data-toggle="modal" data-target="#startModal">Rate</a>
                    <a type="button" class="btn btn-primary btn-choose-new {{ $company_id!=0 ? '' : 'no_display'}}">Choose a new </a>  
                </td>
            </tr>
        @endforeach
    </table>

   
</div>
<div id="startModal" class="modal fade my-pool-service-company" role="dialog">
    <form role="form" action="{{route('rating-company')}}" method="post">
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
                                <input id="ratings-hidden" name="company_point" type="hidden" value="{{$point or 0}}">
                                <input id="company_id" name="company_id" type="hidden" value="{{$company_id}}">                        
                                <div class="text-cnter">
                                    <div class="stars starrr" data-rating="{{$point or 0}}"></div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>

        </div>
    </form>
</div>
