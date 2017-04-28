<div class="row">
	<div class="col-md-8">
		<!-- tabs left -->
		<div class="tabbable">
			<ul class="nav nav-pills nav-stacked col-md-2">
				@foreach($schedules as $schedule)
					<li class="{{ $schedule['name'] == getdate()['weekday'] ? ' active' : ''}}"><a href="#{{$schedule['name']}}" data-toggle="tab">{{$schedule['name']}}</a></li>
				@endforeach
				<div class="clearfix"></div>

			</ul>
			<br />
			<div class="tab-content col-md-10">
				@foreach($schedules as $schedule)
					<div class="tab-pane {{ $schedule['name'] == getdate()['weekday'] ? ' active' : ''}}" id="{{$schedule['name']}}">   
						@include('technician.day-of-week', $schedule)
					</div>
				@endforeach
			</div>
		</div>
		<!-- /tabs -->
	</div>
	<div class="col-md-4">
        <div>
            <div class="panel panel-default">
                <div class="text-center header">Maps</div>
                <div class="panel-body text-center">
                    <div id="map" class="map"></div>
                    &nbsp;
                    <div id="warnings-panel"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /row -->

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