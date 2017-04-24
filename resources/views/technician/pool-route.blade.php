<div class="row">
	<div class="col-md-12">
		<!-- tabs left -->
		<div class="tabbable">
			<ul class="nav nav-pills nav-stacked col-md-2">
				<li class="active"><a href="#monday" data-toggle="tab">Monday</a></li>
				<li><a href="#tuesday" data-toggle="tab">Tuesday</a></li>
				<li><a href="#wednesday" data-toggle="tab">Wednesday</a></li>
				<li><a href="#thursday" data-toggle="tab">Thursday</a></li>
				<li><a href="#friday" data-toggle="tab">Friday</a></li>
			</ul>
			<div class="tab-content col-md-10">
				<div class="tab-pane active" id="monday">                
					@include('technician.day-of-week')
				</div> 
				<div class="tab-pane" id="tuesday"> 
					@include('technician.day-of-week')				
				</div>
			
				<div class="tab-pane" id="wednesday"> 
					@include('technician.day-of-week')						
				</div>
			
				<div class="tab-pane" id="thursday"> 
					@include('technician.day-of-week')						 
				</div>

				<div class="tab-pane" id="friday"> 
					@include('technician.day-of-week')						 
				</div>
			</div>
		</div>
		<!-- /tabs -->
	</div>

</div>
<!-- /row -->
