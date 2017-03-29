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
}
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
                    <input type="text" name="zipcode" placeholder="Enter zipcode max 5 characters..." 
                    class="zipcode form-control" id="zipcode" maxlength="5" required>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-next-zipcode">Next</button>
                </div>
            </fieldset>

            <fieldset id="cbgroup">
                <h4 class="text-center">Type of service</h4>
                <div class="form-group">                        
                    <input type="checkbox" name="chk_service_type[]" value="weekly_learning" id="chk-type-weekly">
                    <label for="chk-type-weekly">Weekly leaning</label>
                </div>
                <div class="form-group">                        
                    <input type="checkbox" name="chk_service_type[]" value="pool_spa_repair" id="chk-type-poolspa">
                    <label for="chk-type-poolspa">Pool or spa repair</label>
                </div>
                <div class="form-group" >                        
                    <input type="checkbox" name="chk_service_type[]" value="deep_cleaning" id="chk-type-deepcleaning">
                    <label for="chk-type-deepcleaning" id="lblServiceType">Deep cleaning</label>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="button" class="btn btn-next">Next</button>
                </div>
            </fieldset>
            
            <fieldset>
                <h4 class="text-center">Weekly cleaning-<span id="weekly_money">$25</span></h4>
                <div class="form-group">                        
                    <input type="checkbox" name="chk_weekly_pool[]" value="pool" id="chk-weekly-pool" class="chk-service-weely">
                    <input type="hidden" name="price" id="hdf_price">
                    <label for="chk-weekly-pool">POOL</label>   
                    <div class="row"> 
                        <div class="col-md-4 centered">
                            <p id="error_weekly_pool">
                                <input name="rdo_weekly_pool" type="radio" value="salt" id="rdo-salwater" class="require-one"/> 
                                <label for="rdo-salwater">Salwater</label>
                                <input name="rdo_weekly_pool" type="radio" value="chlorine" id="rdo-chlorine" class="require-one"/> 
                                <label for="rdo-chlorine">chlorine</label>
                            </p>
                        </div>                    
                    </div>                     
                </div>
                
                <div class="form-group" >                        
                    <input type="checkbox" name="chk_weekly_pool[]" value="spa" id="chk-weekly-spa" class="chk-service-weely">
                    <label for="chk-weekly-spa" id=lblSpa>SPA</label>
                </div>
                <div class="form-group"> 
                    <label for="f1-text">Test and adjust chemicals, backwash the filter, empty the skimmer and pump baskets, brush walls and steps, and skim debirs from water surface.</label>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="button" class="btn btn-next-weekly">Next</button>
                </div>
            </fieldset>

            <fieldset>
                <h4 class="text-center">Your information</h4>
                <div class="form-group">
                    <input type="text" name="email" required placeholder="Email..." class="email form-control" id="email">
                </div>
                <div class="form-group">
                    <input type="password" required name="password" placeholder="Password..." class="password form-control" id="password">
                </div>
                <div class="form-group">
                    <input type="password" required name="repeat-password" placeholder="Repeat password..." 
                                        class="repeat-password form-control" id="repeat-password">
                </div>
                <div class="form-group">
                    <input type="text" name="fullname" required placeholder="Fullname" class="fullname form-control" id="fullname">
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
                        <input type="text" name="zip" maxlength="5" placeholder="zipcode" class="f1-state-number form-control" id="f1-zipcode">
                    </div>	
                </div>

                <div class="form-group">
                    <input type="text" name="phone" required placeholder="Telephone" class="f1-telephone form-control" id="f1-telephone">
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
                            <input type="text" required name="card_name" placeholder="Name on your card" class="f1-name-card form-control" id="f1-name-card">
                        </div>
                        <div class="form-group" id="error_token">
                            <input type="tel" required name="card_number" id="card_number" placeholder="Credit card number"
                            class="f1-cardnumber form-control" id="f1-cardnumber">
                            <input type='hidden' required id='hdf_stripeToken' name='stripeToken'/>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <input type="tel" required name="expiration_date" placeholder="Expirate date" autocomplete="f1-expiration-date" placeholder="•• / ••"
                                class="f1-expiration-date form-control" id="f1-expiration-date">
                            </div>	
                            <div class="col-sm-5 form-group">
                                <input type="text" required name="ccv" placeholder="1234" maxlength="4" class="f1-ccv-number form-control" id="f1-ccv-number">
                            </div>	                        
                        </div>
                    </div>
                    <div class="col-sm-6 text-left">
                        <div class="form-group">
                            <input type="checkbox" name="chk_billing_address" id="chk_billing_address">
                            <label for="chk_billing_address">Same as service address</label>   
                        </div>
                        <div class="form-group">
                            <input type="text" required name="billing_address" placeholder="Street address" 
                            class="f1-billing-street-address form-control" id="f1-billing-street-address">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="billing_city" placeholder="City" class="f1-billing-city form-control" id="f1-billing-city">
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
                                <input type="text" name="billing_zipcode" placeholder="Zipcode..." 
                                maxlength="5" class="f1-billing-zipcode form-control" id="f1-billing-zipcode">
                            </div>	                        
                        </div>
                    </div>
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-previous">Back</button>
                    <button type="button" class="btn btn-next-billing">Next</button>
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

<!-- Modal email notify-->
  <div class="modal fade" id="zipcodeModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">        
        <form id="frmEmailNotify" role="form" action="{{route('add-email-notify')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Not in service area. Enter email address to be notified when your area is covered</label>  
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="not-exist-email" required id="not_exist_email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-off"></span> Send</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>            
          </form>     
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal completed notify-->
  <div class="modal fade" id="completedRegis" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">        
        <form id="frmcompletedRegis" role="form">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Yoy are almost done! Please check your email at (<span id="get_your_email"><span>) and follow the instruction to completed the sign up process</label>  
            </div>
            <div class="form-group">
                <button type="button" id="btnOkGotIt" class="btn btn-success">OK Got It</button>
            </div>            
          </form>     
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('lib')
        <script src="http://parsleyjs.org/dist/parsley.js"></script>    
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script src="{{ asset('js/jquery.backstretch.min.js') }}"></script>
        <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('js/jquery.payment.js') }}"></script>
        <script src="{{ asset('js/jquery.payment.min.js') }}"></script>
        <script src="{{ asset('js/additional-methods.js') }}"></script>
        <script src="{{ asset('js/retina-1.1.0.min.js') }}"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
@endsection

