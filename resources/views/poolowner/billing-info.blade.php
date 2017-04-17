  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="form-horizontal text-left" id="formBillingInfo" role="form">
        <fieldset>

          <!-- Form Name -->
          <legend>Billing Info</legend>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">Name Card</label>
            <div class="col-sm-10">
              <input type="text" placeholder="Name Card" name="name_card" class="form-control" {{ $isEdit ? '' : 'readonly' }} value="{{$billing_info->name_card}}">
            </div>
          </div>

           <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">Number Card</label>
            <div class="col-sm-10">
              <input type="text" placeholder="Number Card" name="card_last_digits" class="form-control" {{ $isEdit ? '' : 'readonly' }} value="{{$billing_info->card_last_digits}}">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">Expiration Date</label>
            <div class="col-sm-10">
              <input type="text" placeholder="Expiration Date" name="expiration_date" class="form-control" {{ $isEdit ? '' : 'readonly' }} value="{{$billing_info->expiration_date}}">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">Address</label>
            <div class="col-sm-10">
              <input type="text" placeholder="Address" name="address" class="form-control" {{ $isEdit ? '' : 'readonly' }} value="{{$billing_info->address}}">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">City</label>
            <div class="col-sm-10">
              <input type="text" placeholder="City" name="city" class="form-control" {{ $isEdit ? '' : 'readonly' }} value="{{$billing_info->city}}">
            </div>
          </div>
          
          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="textinput">State</label>
            <div class="col-sm-4">
              <input type="text" placeholder="State" name="state" class="form-control" {{ $isEdit ? '' : 'readonly' }} value="{{$billing_info->state}}">
            </div>

            <label class="col-sm-2 control-label" for="textinput">Zipcode</label>
            <div class="col-sm-4">
              <input type="text" placeholder="Zip Code" name="zipcode" class="form-control" {{ $isEdit ? '' : 'readonly' }} value="{{$billing_info->zipcode}}">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                @if(!isset($isEdit)||$isEdit)
                    <button type="submit" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                @else
                    <button type="submit" class="btn btn-primary">Edit</button>                    
                @endif
              </div>
            </div>
          </div>

        </fieldset>
      </form>
    </div>
</div>
@section('lib')    
        {{-- <script src="http://parsleyjs.org/dist/parsley.js"></script>    
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>

        <script src="{{ asset('/js/register/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('/js/billinginfo.js') }}"></script> --}}
@endsection
