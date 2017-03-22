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
    label.error { float: none; color: red; margin: 0 .5em 0 0; vertical-align: top; font-size: 15px; display:block }
</style>

<div class="container">
    <div class="col-sm-10 col-sm-offset-1 col-md-12 col-md-offset-2 col-lg-6 col-lg-offset-2 form-box">
        <form role="form" id="frmPoolSubscriber" action="{{route('user-regis-service')}}" method="post" class="f1">
        {{ csrf_field() }}
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
                    <input type="text" require="true" name="zipcode" placeholder="Zip code..." 
                    class="zipcode form-control" id="zipcode" required>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-next">Next</button>
                </div>
            </fieldset>

            <fieldset id="cbgroup">
                <h4 class="text-center">Type of service</h4>
                <div class="form-group">                        
                    <input type="checkbox" name="chk_service_type[]" value="weekly" id="chk-type-weekly">
                    <label for="chk-type-weekly">Weekly leaning</label>
                </div>
                <div class="form-group">                        
                    <input type="checkbox" name="chk_service_type[]" value="poolspa" id="chk-type-poolspa">
                    <label for="chk-type-poolspa">Pool or spa repair</label>
                </div>
                <div class="form-group">                        
                    <input type="checkbox" name="chk_service_type[]" value="deepcleaning" id="chk-type-deepcleaning">
                    <label for="chk-type-deepcleaning">Deep cleaning</label>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="button" class="btn btn-next">Next</button>
                </div>
            </fieldset>
            
            <fieldset>
                <h4 class="text-center">Weekly cleaning-$25</h4>
                <div class="form-group">                        
                    <input type="checkbox" name="chk-weekly-pool" id="chk-weekly-pool">
                    <label for="chk-weekly-pool">POOL</label>                        
                </div>
                <div class="form-group"> 
                    <label class="radio-inline" for="rdo-salwater">
                        <input type="radio" name="rdo-salwater" id="rdo-salwater" checked="checked">
                        Salwater
                    </label> 
                    <label class="radio-inline" for="rdo-chlorine">
                        <input type="radio" name="rdo-chlorine" id="rdo-chlorine">
                        Chlorine
                    </label>
                </div>
                <div class="form-group">                        
                    <input type="checkbox" name="chk-weekly-spa" id="chk-weekly-spa">
                    <label for="chk-weekly-spa">SPA</label>
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
                    <input type="text" name="email" placeholder="Email..." class="email form-control" id="email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password..." class="password form-control" id="password">
                </div>
                <div class="form-group">
                    <input type="password" name="repeat-password" placeholder="Repeat password..." 
                                        class="repeat-password form-control" id="repeat-password">
                </div>
                <div class="form-group">
                    <input type="text" name="fullname" placeholder="Fullname" class="fullname form-control" id="fullname">
                </div>
                <div class="form-group">
                    <input type="text" name="street" placeholder="Address" class="street form-control" id="street">
                </div>
                <div class="form-group">
                    <input type="text" name="city" placeholder="City" class="city form-control" id="city">
                </div>
                <div class="row">
                    <div class="col-sm-7 form-group">
                        <select id="select-state" name="state" class="form-control input-md">
                            <option>Arizona</option>
                            <option>Los Angeles</option>
                            <option>California</option>
                            <option>Carolina</option>
                            <option>New England</option>
                        </select>
                    </div>		
                    <div class="col-sm-5 form-group">
                        <input type="text" name="zip" placeholder="85085" class="f1-state-number form-control" id="f1-state-number">
                    </div>	
                </div>

                <div class="form-group">
                    <input type="text" name="phone" placeholder="Telephone" class="f1-telephone form-control" id="f1-telephone">
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
                            <input type="text" name="card_name" placeholder="Name on your card" class="f1-name-card form-control" id="f1-name-card">
                        </div>
                        <div class="form-group">
                            <input type="text" name="card_number" placeholder="Credit card number" class="f1-cardnumber form-control" id="f1-cardnumber">
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <input type="text" name="expiration_date" placeholder="Expirate date" class="f1-expiration-date form-control" id="f1-expiration-date">
                            </div>	
                            <div class="col-sm-5 form-group">
                                <input type="text" name="ccv" placeholder="1234" maxlength="4" class="f1-ccv-number form-control" id="f1-ccv-number">
                            </div>	                        
                        </div>
                    </div>
                    <div class="col-sm-6 text-left">
                        <div class="form-group">
                            <input type="text" name="billing_address" placeholder="Street address" class="f1-billing-street-address form-control" id="f1-billing-street-address">
                        </div>
                        <div class="form-group">
                            <input type="text" name="billing_city" placeholder="City" class="f1-billing-city form-control" id="f1-billing-city">
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <select id="billing_state" name="billing_state" class="form-control input-md">
                                    <option>Arizona</option>
                                    <option>Los Angeles</option>
                                    <option>California</option>
                                    <option>Carolina</option>
                                    <option>New England</option>
                                </select>
                            </div>	
                            <div class="col-sm-5 form-group">
                                <input type="text" name="zipcode" placeholder="85085" maxlength="10" class="f1-billing-zipcode form-control" id="f1-billing-zipcode">
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

@section('lib')
        <script src="{{ asset('js/jquery.backstretch.min.js') }}"></script>
        <script src="{{ asset('js/retina-1.1.0.min.js') }}"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
@endsection