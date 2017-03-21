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
    <div class="col-sm-10 col-sm-offset-1 col-md-12 col-md-offset-2 col-lg-6 col-lg-offset-2 form-box">
        <form role="form" action="" method="post" class="f1">

            <h3>Register To Our App</h3>
            <p>Fill in the form to get instant access</p>
            </space>
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
            </space>
            <fieldset>
                <h4 class="text-center">Enter your zip code</h4>
                <div class="form-group">
                    <input type="text" require="true" name="f1-zip-code" placeholder="Zip code..." 
                    class="f1-zip-code form-control" id="f1-zip-code">
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-next">Next</button>
                </div>
            </fieldset>

            <fieldset>
                <h4 class="text-center">Type of service</h4>
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
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="button" class="btn btn-next">Next</button>
                </div>
            </fieldset>
            
            <fieldset>
                <h4 class="text-center">Weekly cleaning-$25</h4>
                <div class="form-group">                        
                    <input type="checkbox" name="f1-pool" id="f1-pool">
                    <label for="f1-pool">POOL</label>                        
                </div>
                <div class="form-group"> 
                    <label class="radio-inline" for="rdo-salwater">
                        <input type="radio" name="rdo-salwater" id="rdo-salwater" value="rdo_yes" checked="checked">
                        Salwater
                    </label> 
                    <label class="radio-inline" for="rdo-dinner">
                        <input type="radio" name="rdo-dinner" id="rdo-dinner" value="rdo_no">
                        Chlorine
                    </label>
                </div>
                <div class="form-group">                        
                    <input type="checkbox" name="f1-spa" id="f1-spa">
                    <label for="f1-spa">SPA</label>
                </div>
                <div class="form-group"> 
                    <label for="f1-text">Test and adjust chemicals, backwash the filter, empty the skimmer and pump baskets, brush walls and steps, and skim debirs from water surface.</label>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="button" class="btn btn-next">Next</button>
                </div>
            </fieldset>

            <fieldset>
                <h4 class="text-center">Your information</h4>
                <div class="form-group">
                    <input type="text" name="f1-email" placeholder="Email" class="f1-email form-control" id="f1-email">
                </div>
                <div class="form-group">
                    <input type="password" name="f1-password" placeholder="Password..." class="f1-password form-control" id="f1-password">
                </div>
                <div class="form-group">
                    <input type="password" name="f1-repeat-password" placeholder="Repeat password..." 
                                        class="f1-repeat-password form-control" id="f1-repeat-password">
                </div>
                <div class="form-group">
                    <input type="text" name="f1-fullname" placeholder="Fullname" class="f1-fullname form-control" id="f1-fullname">
                </div>
                <div class="form-group">
                    <input type="text" name="f1-address" placeholder="Address" class="f1-address form-control" id="f1-address">
                </div>
                <div class="form-group">
                    <input type="text" name="f1-city" placeholder="City" class="f1-city form-control" id="f1-city">
                </div>
                <div class="row">
                    <div class="col-sm-7 form-group">
                        <select id="select-state" name="select-state" class="form-control input-md">
                            <option>Arizona</option>
                            <option>Los Angeles</option>
                            <option>California</option>
                            <option>Carolina</option>
                            <option>New England</option>
                        </select>
                    </div>		
                    <div class="col-sm-5 form-group">
                        <input type="text" name="f1-state-number" placeholder="85085" class="f1-state-number form-control" id="f1-state-number">
                    </div>	
                </div>

                <div class="form-group">
                    <input type="text" name="f1-telephone" placeholder="Telephone" class="f1-telephone form-control" id="f1-telephone">
                </div>

                <div class="f1-buttons">
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="button" class="btn btn-next">Next</button>
                </div>
            </fieldset>

            <fieldset>
                <div><h4 class="text-center">Enter your credit card information. Your card will not be billed until day of service. $25/week</h4></div>
                </space>
                <div class="row vdivide">
                    <div class="col-sm-6 text-left">
                        <div class="form-group">
                            <input type="text" name="f1-name-card" placeholder="Name on your card" class="f1-name-card form-control" id="f1-name-card">
                        </div>
                        <div class="form-group">
                            <input type="text" name="f1-cardnumber" placeholder="Credit card number" class="f1-cardnumber form-control" id="f1-cardnumber">
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <input type="text" name="f1-expiration-date" placeholder="Expirate date" class="f1-expiration-date form-control" id="f1-expiration-date">
                            </div>	
                            <div class="col-sm-5 form-group">
                                <input type="text" name="f1-ccv-number" placeholder="1234" maxlength="4" class="f1-ccv-number form-control" id="f1-ccv-number">
                            </div>	                        
                        </div>
                    </div>
                    <div class="col-sm-6 text-left">
                        <div class="form-group">
                            <input type="text" name="f1-billing-street-address" placeholder="Street address" class="f1-billing-street-address form-control" id="f1-billing-street-address">
                        </div>
                        <div class="form-group">
                            <input type="text" name="f1-billing-city" placeholder="City" class="f1-billing-city form-control" id="f1-billing-city">
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <select id="select-billing-state" name="select-billing-state" class="form-control input-md">
                                    <option>Arizona</option>
                                    <option>Los Angeles</option>
                                    <option>California</option>
                                    <option>Carolina</option>
                                    <option>New England</option>
                                </select>
                            </div>	
                            <div class="col-sm-5 form-group">
                                <input type="text" name="f1-billing-zipcode" placeholder="85085" maxlength="10" class="f1-billing-zipcode form-control" id="f1-billing-zipcode">
                            </div>	                        
                        </div>
                    </div>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="button" class="btn btn-next">Next</button>
                </div>
            </fieldset>
        

            <fieldset>
                <h4 class="text-center">Finalize order</h4>
                <div class="row vdivide">
                    <div class="col-sm-4 text-left">
                        <div class="form-group">
                            <h4 class="text-left">Service information</h4>
                        </div>
                        <div class="form-group">
                            <h4 class="text-center">Account information</h4>
                        </div>
                        <div class="form-group">
                            <h4 class="text-center">Billing information</h4>                    
                        </div>
                    </div>
                    <div class="col-sm-8 text-left">
                        <div class="form-group">
                            <h4 class="text-center">Weekly cleaning - $25</h4>
                            <h4 class="text-center">Pool - chlorine</h4>
                        </div>
                        <div class="form-group">
                            <h4 class="text-center">Email address:</h4>
                            <h4 class="text-center">Password:</h4>
                            <h4 class="text-center">First name:</h4>
                            <h4 class="text-center">Address</h4>
                            <h4 class="text-center">City, ST zipcode</h4>
                        </div>
                        <div class="row">
                            <h4 class="text-center">Billing image and information</h4>                       
                            <h4 class="text-center">Billing address:</h4>
                        </div>
                    </div>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="submit" class="btn btn-submit">Submit</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection




