<div class="box-body table-responsive no-padding company-offered-service">
    <table class="table table-hover">
        <tr>
            <th><a style='cursor:pointer;'></a></th>
            <th><a style='cursor:pointer;'>Services</a></th>
            <th><a style='cursor:pointer;'>Zipcode</a></th>
            <th><a style='cursor:pointer;'>Time</a></th>
            <th><a style='cursor:pointer;'>Water</a></th>
            <th><a style='cursor:pointer;'>Price</a></th>
        </tr>
        @foreach ($offers as $offer)
            <tr>	
                <td valign="middle"></td>
                <td valign="middle">{{$offer->services}}</td>
                <td valign="middle">{{$offer->zipcode}}</td>
                <td valign="middle">{{$offer->time}}</td>
                <td valign="middle">{{$offer->water}}</td>
                <td valign="middle">{{$offer->price}}</td>
            </tr>
        @endforeach
    </table>
</div>