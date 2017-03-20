@extends('layouts.template')

@section('content')

<style>
input[type="checkbox"] {
    width: 24px;
    height: 24px;
    vertical-align: bottom;
}
label.checkbox {
    vertical-align: top;
    line-height: 24px;
    margin: 2px 0;
    display: block;
    height: 24px;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 form-box">
            <form role="form" action="" method="post" class="f1">

                <h3>Register To Our App</h3>
                <p>Fill in the form to get instant access</p>
                </br>
                <div class="f1-steps">
                    <div class="f1-progress">
                        <div class="f1-progress-line" data-now-value="12.5" data-number-of-steps="5" style="width: 12.5%;"></div>
                    </div>
                    <div class="f1-step active">
                        <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    </div>
                    <div class="f1-step">
                        <div class="f1-step-icon"><i class="fa fa-gears"></i></div>
                    </div>
                    <div class="f1-step">
                        <div class="f1-step-icon"><i class="fa fa-tasks"></i></div>
                    </div>
                    <div class="f1-step">
                        <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    </div>

                    <div class="f1-step">
                        <div class="f1-step-icon"><i class="fa fa-credit-card-alt"></i></div>
                    </div>

                    <div class="f1-step">
                        <div class="f1-step-icon"><i class="fa fa-wpforms"></i></div>
                    </div>
                </div>
                </br>
                <fieldset>
                    <h4>Enter your zip code</h4>
                    <div class="form-group">
                        <label class="sr-only" for="f1-zip-code">Zip code</label>
                        <input type="text" require="true" name="f1-zip-code" placeholder="Zip code..." class="f1-zip-code form-control" id="f1-zip-code">
                    </div>
                    <div class="f1-buttons">
                        <button type="button" class="btn btn-next">Next</button>
                    </div>
                </fieldset>

                <fieldset>
                    <h4>Type of service</h4>
                    <div class="form-group">                        
                        <input type="checkbox" name="f1-email" id="f1-email">
                        <label for="f1-email">Weekly leaning</label>
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="f1-password" id="f1-password">
                        <label for="f1-password">Pool or spa repair</label>
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="f1-repeat-password"id="f1-repeat-password">
                        <label for="f1-repeat-password">Deep cleaning</label>
                    </div>
                    <div class="f1-buttons">
                        <button type="button" class="btn btn-previous">Previous</button>
                        <button type="button" class="btn btn-next">Next</button>
                    </div>
                </fieldset>
                
                <fieldset>
                    <h4>Weekly cleaning-$25</h4>
                    <div class="form-group">                        
                        <input type="checkbox" name="f1-pool" id="f1-pool">
                        <label for="f1-pool">POOL</label>
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="f1-spa" id="f1-spa">
                        <label for="f1-spa">SPA</label>
                    </div>
                    <div class="form-group"> 
                        <label for="f1-text">Test and adjust chemicals, backwash the filter, empty the skimmer and pump baskets, brush walls and steps, and skim debirs from water surface.</label>
                    </div>
                    <div class="f1-buttons">
                        <button type="button" class="btn btn-previous">Previous</button>
                        <button type="button" class="btn btn-next">Next</button>
                    </div>
                </fieldset>

                <fieldset>
                    <h4>Your information</h4>
                    <div class="form-group">
                        <label class="sr-only" for="f1-email">Email</label>
                        <input type="text" name="f1-email" placeholder="Enter email address..." class="f1-email form-control" id="f1-email">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-re-email">Email</label>
                        <input type="text" name="f1-re-email" placeholder="Re-enter email address..." class="f1-re-email form-control" id="f1-re-email">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-password">Password</label>
                        <input type="password" name="f1-password" placeholder="Create password..." class="f1-password form-control" id="f1-password">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-repeat-password">Repeat password</label>
                        <input type="password" name="f1-repeat-password" placeholder="Repeat password..." 
                                            class="f1-repeat-password form-control" id="f1-repeat-password">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-fullname">Fullname</label>
                        <input type="text" name="f1-fullname" placeholder="Enter fullname" class="f1-fullname form-control" id="f1-fullname">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-address">Address</label>
                        <input type="textarea" name="f1-address" placeholder="Enter address" class="f1-address form-control" id="f1-address">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-city">City</label>
                        <input type="text" name="f1-city" placeholder="City" class="f1-city form-control" id="f1-city">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-state">State</label>
                        <input type="text" name="f1-state" placeholder="State" class="f1-state form-control" id="f1-state">
                        <input type="text" name="f1-state1" placeholder="State1" class="f1-state1 form-control" id="f1-state1">
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="f1-telephone">Telephone</label>
                        <input type="text" name="f1-telephone" placeholder="Telephone" class="f1-telephone form-control" id="f1-telephone">
                    </div>

                    <div class="f1-buttons">
                        <button type="button" class="btn btn-previous">Previous</button>
                        <button type="button" class="btn btn-next">Next</button>
                    </div>
                </fieldset>

                <fieldset>
                    <h4>Billing</h4>
                    <div class="form-group">
                        <label class="sr-only" for="f1-facebook">Facebook</label>
                        <input type="text" name="f1-facebook" placeholder="Facebook..." class="f1-facebook form-control" id="f1-facebook">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-twitter">Twitter</label>
                        <input type="text" name="f1-twitter" placeholder="Twitter..." class="f1-twitter form-control" id="f1-twitter">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-google-plus">Google plus</label>
                        <input type="text" name="f1-google-plus" placeholder="Google plus..." class="f1-google-plus form-control" id="f1-google-plus">
                    </div>
                    <div class="f1-buttons">
                        <button type="button" class="btn btn-previous">Previous</button>
                        <button type="button" class="btn btn-next">Next</button>
                    </div>
                </fieldset>
            

                <fieldset>
                    <h4>Finalize order</h4>
                    <div class="form-group">
                        <label class="sr-only" for="f1-facebook">Facebook</label>
                        <input type="text" name="f1-facebook" placeholder="Facebook..." class="f1-facebook form-control" id="f1-facebook">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-twitter">Twitter</label>
                        <input type="text" name="f1-twitter" placeholder="Twitter..." class="f1-twitter form-control" id="f1-twitter">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="f1-google-plus">Google plus</label>
                        <input type="text" name="f1-google-plus" placeholder="Google plus..." class="f1-google-plus form-control" id="f1-google-plus">
                    </div>
                    <div class="f1-buttons">
                        <button type="button" class="btn btn-previous">Previous</button>
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@endsection




