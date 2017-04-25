<div class="box-body table-responsive no-padding company-offered-service">
    <table class="table table-hover" data-delurl="" data-updateurl="{{ route('dashboard-company-update-offer') }}" >
        <tr>
            <th><a></a></th>
            <th><a>Services</a></th>
            <th><a>Zipcode</a></th>
            <th><a>Time</a></th>
            <th><a>Water</a></th>
            <th><a>Price</a></th>
            <th><a>status</a></th>
            <th></th>
        </tr>
        @foreach ($offers as $offer)
            <tr>	
                <td></td>
                <td>{{$offer->services}}</td>
                <td>{{$offer->zipcode}}</td>
                <td>{{$offer->time}}</td>
                <td>{{$offer->water}}</td>
                <td>{{$offer->price}}</td>
                <td class="status">{{$offer->offer_status}}</td>
                <td>
                    <span class="glyphicon glyphicon-ok icon accept-service-offer" data-id="{{$offer->offer_id}}" data-status="active"></span> | 
                    <span class="glyphicon glyphicon-remove icon deny-service-offer" data-id="{{$offer->offer_id}}" data-status="denied"></span>
                </td>
            </tr>
        @endforeach
    </table>
</div>