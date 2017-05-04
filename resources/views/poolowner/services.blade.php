<div class="row">
    <div class="col-md-12">
        <div class="well well-sm">
            <div class="box-body table-responsive no-padding services" style='overflow:visible;'>
                <table class="table table-hover">
                    <tr>
                        <th class="text-center" width="350px"><a style='cursor:pointer;'>Service(s)</a></th>
                        <th class="text-center" width="150px"><a style='cursor:pointer;'>Date</a></th>
                        <th class="text-center" width="150px"><a style='cursor:pointer;'>Amount</a></th>                     
                        <th></th>                     
                    </tr>
                    @foreach ($schedules as $key=>$sc)
                        <tr class="item schedule item-schedule-poolowner" data-target="#cleaningStepsInfoModal" data-toggle="modal"  >
                            <td valign="middle" class="service_name text-center" width="350px">
                                <span>{{$sc->service_name}}</span>                           
                                <input type="hidden" name="date" value="{{$sc->date}}">
                                <input type="hidden" name="dateFormat" value="{{$sc->dateFormat}}">
                                {{-- <input type="hidden" name="now" value="{{new \DateTime()}}"> --}}
                                <input type="hidden" name="cleaning_steps" value="{{$sc->cleaning_steps}}">                                
                                <input type="hidden" name="comment" value="{{$sc->comment}}">                           
                                <input type="hidden" name="status" value="{{$sc->status}}" style="width: 95px; ">                           
                            </td>
                            <td valign="middle" width="150px" class="text-center" ><span>{{$sc->dateFormat}}</span></td>
                            <td valign="middle" width="150px" class="text-center" ><span>{{$sc->price}}</span></td>
                            <td valign="middle">
                                <label style="font-size: 1em" class="btn-status btn-upcoming {{ $sc->status == 'checkin' || $sc->status == 'opening' ? '' : 'no_display'}} ">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> Service upcoming
                                </label>
                                <label style="font-size: 1em" class="btn-status btn-billing-success {{$sc->status == 'billing_success' ? '' : 'no_display'}} ">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> Billing success
                                </label>
                                <label style="font-size: 1em" class="btn-status btn-billing-error {{$sc->status == 'billing_error' ? '' : 'no_display'}} ">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Billing error
                                </label>
                                <label style="font-size: 1em" class="btn-status btn-unable {{$sc->status == 'unable' ? '' : 'no_display'}} ">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Service uncomplete
                                </label>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    
</div>

<div id="cleaningStepsInfoModal" class="modal fade services confirm-info-steps" role="dialog">
    <form role="form" method="post" id="form-confirm-info-steps">
    {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cleaning Steps</h4>
                </div>
                <div class="modal-body">
                    <div class="row" id="post-review-box">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="text-left">
								<div class="row">
									<div class="col-md">
										<fieldset>
											<div>
												<h5>Weekly cleaniing <span id="day-of-schedule">03-03-2017</span></h5>
												<input name="schedule_id" id="schedule_id" type="hidden" value="0">
											</div>
											<div class="checkbox">
												<input name="step1" id="step1" type="checkbox" onclick="return false;">
												<label for="step1">
													Test and adjust chemicals
												</label>
												<br/>
												<label>- Alkalinity: HI ppm</label>
												<br/>													
												<label>- pH balance: 7.9 pH</label>
											</div>
											<div class="checkbox">
												<input name="step2" id="step2" type="checkbox" onclick="return false;">
												<label for="step2">
													Backwash the filter
												</label>
											</div>
											<div class="checkbox">
												<input name="step3" id="step3" type="checkbox" onclick="return false;">
												<label for="step3">
													Empty the skimmer
												</label>
											</div>
											<div class="checkbox">
												<input name="step4" id="step4" type="checkbox" onclick="return false;">
												<label for="step4">
													Empty the pump baskets
												</label>
											</div>
											<div class="checkbox">
												<input name="step5" id="step5" type="checkbox" onclick="return false;">
												<label for="step5">
													Brush walls and steps
												</label>
											</div>
											<div class="checkbox">
												<input name="step6" id="step6" type="checkbox" onclick="return false;">
												<label for="step6">
													Skim debris from water surface
												</label>
											</div>
											<div class="form-group">
												<label for="comment">Comment: </label>
												<label name="comment" id="comment"></label>
                                                <br />
												<label name="recommendation" id="recommendation">Recommendation: </label>
											</div>
										</fieldset>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning"  data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </form>
</div>

