<div class="box-body table-responsive no-padding company-offered-service">
    <table class="table table-hover" data-url="{{ route('dashboard-company-accept-deny-offer') }}" >
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
        @foreach ($offerFromPoolowner as $offer)
            <tr>	
                <td></td>
                <td>{{$offer->services}}</td>
                <td>{{$offer->zipcode}}</td>
                <td>{{$offer->time}}</td>
                <td>{{$offer->water}}</td>
                <td>{{$offer->price}}</td>
                <td class="status">
                    <span class="glyphicon offer_status icon" aria-hidden="true"></span>
                </td>
                <td>
                    <span class="glyphicon glyphicon-ban-circle icon deny-service-offer" aria-hidden="true" data-id="{{$offer->offer_id}}" data-status="denied"></span>
                    <span class="glyphicon glyphicon-ok-circle icon accept-service-offer" aria-hidden="true" data-id="{{$offer->offer_id}}" data-status="active"></span>
                </td>
            </tr>
        @endforeach
    </table>
</div>