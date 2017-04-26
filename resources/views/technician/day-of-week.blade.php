<div class="row">
    <div class="col-md-12">
        <div class="well well-sm">
            <div class="box-body table-responsive no-padding my-pool-service-company" style='overflow:visible;'>
                <table class="table table-hover">
                    <tr>
                        <th><a style='cursor:pointer;'>Order</a></th>
                        <th><a style='cursor:pointer;'>Street Address</a></th>
                        <th><a style='cursor:pointer;'>City</a></th>
                        <th><a style='cursor:pointer;'>Zipcode</a></th>
                        <th><a style='cursor:pointer;'>Status</a></th>                        
                    </tr>
                    @foreach ($schedule["value"] as $key=>$sc)
                        <tr>
                            <td class="text-center">{{$key}}</td>	
                            <td valign="middle"><span>{{$sc->address}}</span></td>
                            <td valign="middle"><span>{{$sc->city}}</span></td>
                            <td valign="middle"><span>{{$sc->zipcode}}</span></td>
                            <td valign="middle">
                                @if($sc->status=="complete")
                                   <label style="font-size: 1em">
                                        <input type="checkbox" value="1" readonly checked  onclick="return false;">
                                        Complete
                                    </label>
                                @else
                                    <a href="#" type="button" class="btn btn-primary">Enroute</a>                        
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    
</div>

