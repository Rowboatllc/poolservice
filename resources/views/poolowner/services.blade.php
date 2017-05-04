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
                        <tr class="item schedule">
                            <td valign="middle" data-toggle="modal" data-target="#cleaningStepsModal" class="addres-schedule"  width="350px">
                                <span>{{$sc->service_name}}</span>
                                <input type="hidden" name="schedule_id" value="{{$sc->id}}">                                
                                <input type="hidden" name="date" value="{{$sc->date}}">
                                <input type="hidden" name="cleaning_steps" value="{{$sc->cleaning_steps}}">                                
                                <input type="hidden" name="comment" value="{{$sc->comment}}">                           
                                <input type="hidden" name="status" value="{{$sc->status}}" style="width: 95px; ">                           
                            </td>
                            <td valign="middle" width="150px" class="text-center" ><span>{{$sc->date}}</span></td>
                            <td valign="middle" width="150px" class="text-center" ><span>{{$sc->price}}</span></td>
                            <td valign="middle">
                                <label style="font-size: 1em" class="btn-status btn-complete {{$sc->status == 'complete' ? '' : 'no_display'}} ">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> Complete
                                </label>
                                <label style="font-size: 1em" class="btn-status btn-unable {{$sc->status == 'unable' ? '' : 'no_display'}} ">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Unable
                                </label>
                                <a class="btn btn-primary btn-technician technician-checkin {{$sc->status == 'checkin' ? '' : 'no_display'}} btn-status" style="width: 80px;" >Check In</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    
</div>

<div id="cleaningStepsModal" class="modal fade schedule-day-of-week confirm-steps" role="dialog">
    <form role="form" method="post" id="form-confirm-steps">
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
												<input name="step1" id="step1" type="checkbox">
												<label for="step1">
													Test and adjust chemicals
												</label>
												<br/>
												<label>- Alkalinity: HI ppm</label>
												<br/>													
												<label>- pH balance: 7.9 pH</label>
											</div>
											<div class="checkbox">
												<input name="step2" id="step2" type="checkbox">
												<label for="step2">
													Backwash the filter
												</label>
											</div>
											<div class="checkbox">
												<input name="step3" id="step3" type="checkbox">
												<label for="step3">
													Empty the skimmer
												</label>
											</div>
											<div class="checkbox">
												<input name="step4" id="step4" type="checkbox">
												<label for="step4">
													Empty the pump baskets
												</label>
											</div>
											<div class="checkbox">
												<input name="step5" id="step5" type="checkbox">
												<label for="step5">
													Brush walls and steps
												</label>
											</div>
											<div class="checkbox">
												<input name="step6" id="step6" type="checkbox">
												<label for="step6">
													Skim debris from water surface
												</label>
											</div>
											<div class="form-group">
												<label for="comment">Comment:</label>
												<textarea class="form-control" rows="5" name="comment" id="comment" ></textarea>
											</div>
										</fieldset>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-unable-steps" title="{{ route('technician-unable-steps') }}">Unable to service</button>
                    <button type="button" class="btn btn-primary btn-complete-steps" title="{{ route('technician-complete-steps') }}">Service complete</button>
                </div>
            </div>

        </div>
    </form>
</div>

