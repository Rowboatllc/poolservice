<div class="box-body table-responsive no-padding company-offered-service content-block">
    <div class="table-responsive" data-totalpage="{{ceil($offerFromPoolowner->total()/$offerFromPoolowner->perPage())}}" data-page="{{$offerFromPoolowner->currentPage()}}" data-url="{{ route('dashboard-company-getlist-offer') }}" >
        <table class="table table-hover table-list" data-url="{{ route('dashboard-company-accept-deny-offer') }}" >
            <tr>
                <th><span data-orderfield=""></span></th>
                <th><span data-orderfield="services">Services</span></th>
                <th><span data-orderfield="zipcode">Zipcode</span></th>
                <th><span data-orderfield="time">Time</span></th>
                <th><span data-orderfield="water">Water</span></th>
                <th><span data-orderfield="price">Price</span></th>
                <th><span data-orderfield="offer_status">status</span></th>
                <th></th>
            </tr>
            @foreach ($offerFromPoolowner as $item)
                <tr>	
                    <td></td>
                    <td>{{$item->services}}</td>
                    <td>{{$item->zipcode}}</td>
                    <td>{{$item->time}}</td>
                    <td>{{$item->water}}</td>
                    <td>{{$item->price}}</td>
                    <td class="status">
                        <span class="glyphicon offer_status icon {{ $item->offer_status }}" aria-hidden="true"></span>
                    </td>
                    <td>
                        @if ($item->offer_status == 'pending')
                        <span class="glyphicon glyphicon-ban-circle icon deny-service-offer" aria-hidden="true" data-id="{{$item->offer_id}}" data-status="denied"></span>
                        <span class="glyphicon glyphicon-ok-circle icon accept-service-offer" aria-hidden="true" data-id="{{$item->offer_id}}" data-status="active"></span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        <ul class="pagination"></ul>
        <script type="text/x-jquery-tmpl">
            <tr>	
                <td></td>
                <td>${services}</td>
                <td>${zipcode}</td>
                <td>${time}</td>
                <td>${water}</td>
                <td>${price}</td>
                <td class="status">
                    <span class="glyphicon offer_status icon" aria-hidden="true"></span>
                </td>
                <td>
                    <?php //echo '{{if $offer_status=="pending"}}' ?>
                        <span class="glyphicon glyphicon-ban-circle icon deny-service-offer" aria-hidden="true" data-id="${offer_id}" data-status="denied"></span>
                        <span class="glyphicon glyphicon-ok-circle icon accept-service-offer" aria-hidden="true" data-id="${offer_id}" data-status="active"></span>
                   <?php //echo '{{/if}}' ?>
                </td>
            </tr>
        </script>
    </div>
</div>