<div class="company-profile-service">    
    <div class="row sectionB1">
        <form role="form" id="frmPoolServiceDashBoard" action="{{route('upload-company-profile')}}" method="post" class="f2" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-xs-9 bhoechie-tab-container">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                    <div class="list-group">
                        <a href="#" class="list-group-item active text-center">
                            <h4 class="glyphicon glyphicon-plane"></h4><br/>Monday
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h4 class="glyphicon glyphicon-road"></h4><br/>Tuesday
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h4 class="glyphicon glyphicon-home"></h4><br/>Wednesday
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h4 class="glyphicon glyphicon-cutlery"></h4><br/>Thursday
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h4 class="glyphicon glyphicon-roundabout"></h4><br/>Friday
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                    <div class="form-group bhoechie-tab-content active">
                        <div class="row">
                            <div class="col-sm-10">
                                <h4 style="margin-top: 0;color:#55518a">You currently have no routes list on Monday</h4>
                                <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group" >                        
                                    <input type="checkbox" name="chk_monday" value="spa" id="chk_monday" class="chk-monday">
                                    <label for="chk-weekly-spa" id=lblMonday>Not Available</label>
                                </div>
                            </div>
                        </div>                     
                    </div>

                    <div class="form-group bhoechie-tab-content">
                        <div class="row">
                            <div class="col-sm-10">
                                <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group" >                        
                                    <input type="checkbox" name="chk_tuesday" id="chk_tuesday" class="chk_tuesday">
                                    <label for="chk_tuesday" id=lblTuesday>Not Available</label>
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="border-1">
                                
                            </div>

                            <nav class="navbar navbar-default">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <img src="/storage/Screen Shot 2017-04-26 at 9.50.53 PM.png" alt="..." class="rounded-circle">
                                    </div>
                                </div>
                            </nav>
                        </div> 

                        <div class="row">
                            <table>
                                
                            </table>
                        </div> 
                    </div>

                    <div class="form-group bhoechie-tab-content">
                    </div>
                    <div class="form-group bhoechie-tab-content">
                    </div>

                    <div class="form-group bhoechie-tab-content">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>