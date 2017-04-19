<div class="poolowner_profile">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="fieldset" method="POST" action="{{route('update-billing-info')}}">
          {{ csrf_field() }}
          <div class="form-group has-error text-center">                        
              <label class="col control-label" id="payment-errors" style="display:none"></label>
          </div>
          <div class="col-md-3 text-right col"><span class="labeltext">Name Card:</span></div>
          <div class="col-md-9 col">
              <div name="name_card" class="contenteditable" contenteditable="true" data-validate="require">{{$billing_info->name_card}}</div>
              <span class="glyphicon glyphicon-pencil editfieldset_billing icon badge">&nbsp;</span>
              <span class="glyphicon glyphicon-floppy-save savefieldset_billing icon badge no_display">&nbsp;</span>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">Number Card:</span></div>
          <div class="col-md-9 col">
            <div name="card_last_digits" id="card_last_digits" class="contenteditable" contenteditable="true" data-validate="require">********{{$billing_info->card_last_digits}}</div>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">Expiration Date:</span></div>
          <div class="col-md-9 col">
            <div name="expiration_date" class="contenteditable" contenteditable="true" required >{{$billing_info->expiration_date}}</div>
            &nbsp;
            &nbsp;
            <div id="billing_ccv" style="display:none">
              <span > CCV:</span>
              <div name="ccv" class="contenteditable" contenteditable="true" id="ccv_number"></div>
            </div>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">Address:</span></div>
          <div class="col-md-9 col">
            <div name="address" class="contenteditable" contenteditable="true">{{$billing_info->address}}</div>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">City:</span></div>
          <div class="col-md-9 col">
            <div name="city" class="contenteditable" contenteditable="true">{{$billing_info->city}}</div>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">State:</span></div>
          <div class="col-md-9 col">
            <div name="state" class="contenteditable" contenteditable="true">{{$billing_info->state}}</div>
            &nbsp;
            &nbsp;
            <span >Zipcode:</span>
            <div name="zipcode" class="contenteditable" contenteditable="true">{{$billing_info->zipcode}}</div>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>