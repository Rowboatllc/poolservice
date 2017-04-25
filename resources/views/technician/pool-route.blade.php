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
