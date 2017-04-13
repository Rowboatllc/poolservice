<div class="box-body table-responsive no-padding my-pool-service-company" style='overflow:visible;'>
    <table class="table table-hover">
        <tr>
            <th><a style='cursor:pointer;'>Pool Service Company</a></th>
            <th><a style='cursor:pointer;'>Service availability</a></th>
            <th><a style='cursor:pointer;'>Pool Service Rating</a></th>
            <th><a style='cursor:pointer;'></a></th>
        </tr>
        @foreach ($companys as $company)
            <tr>	
                <td valign="middle"><img class="logo" src='{{$company->logo}}' width='100' /> {{$company->name}}</td>
                <td valign="middle">every Tuesday starting March 28,2017</td>
                <td valign="middle"><span class="stars">{{$company->point}}</span></td>
                <td valign="middle">
                    @if(isset($status) && $status=='pending')
                        <a href="#" type="button" class="btn btn-primary">Choose</a>
                    @else
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>