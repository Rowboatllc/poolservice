<div class="row">
    <div class="col-md-12">
        <div class="well well-sm">
            <div class="box-body table-responsive no-padding schedule-day-of-week" style='overflow:visible;'>
                <table class="table table-hover">
                    <tr>
                        <th><a style='cursor:pointer;'>Order</a></th>
                        <th><a style='cursor:pointer;'>Street Address</a></th>
                        <th><a style='cursor:pointer;'>City</a></th>
                        <th><a style='cursor:pointer;'>Zipcode</a></th>
                        <th><a style='cursor:pointer;'>Status</a></th>                        
                    </tr>
                    @foreach ($schedule["value"] as $key=>$sc)
                        <tr class="item schedule">
                            <td class="text-center">{{$key}}</td>
                            <td valign="middle" data-toggle="modal" data-target="#cleaningStepsModal" class="addres-schedule">
                                <span>{{$sc->address}}</span>
                                <input type="hidden" name="date" value="{{$sc->date}}">
                                <input type="hidden" name="cleaning_steps" value="{{$sc->cleaning_steps}}">                                
                                <input type="hidden" name="comment" value="{{$sc->comment}}">                           
                                <input type="hidden" name="status" value="{{$sc->status}}">                           
                            </td>
                            <td valign="middle"><span>{{$sc->city}}</span></td>
                            <td valign="middle"><span>{{$sc->zipcode}}</span></td>
                            <td valign="middle">
                                @if($sc->status=="complete")
                                   <label style="font-size: 1em">
                                        <input type="checkbox" value="1" readonly checked  onclick="return false;">
                                        Complete
                                    </label>
                                @else
                                    <a href="" type="button" class="btn btn-primary" title="{{route('technician-enroute',[$sc->id])}}">Enroute</a>                        
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    
</div>

