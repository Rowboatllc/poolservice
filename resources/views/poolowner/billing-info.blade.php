<div class="poolowner_profile">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div role="form" class="fieldset" method="POST" action="{{route('update-billing-info')}}" id="form-billing-info">
          {{ csrf_field() }}
          <div class="form-group has-error text-center">                        
              <label class="col control-label" id="payment-errors" style="display:none"></label>
          </div>
          <div class="col-md-3 text-right col"><span class="labeltext">Name Card:</span></div>
          <div class="col-md-9 col">
              <div name="name_card" class="contenteditable" contenteditable="false" data-validate="require" maxlength="100">{{$billing_info->name_card or "&nbsp"}}</div>
              <span class="glyphicon glyphicon-pencil editfieldset_billing icon badge">&nbsp;</span>
              <span class="glyphicon glyphicon-floppy-save savefieldset_billing icon badge no_display">&nbsp;</span>
              <span class="glyphicon glyphicon-remove cancel-editfieldset icon badge no_display"></span>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">Number Card:</span></div>
          <div class="col-md-9 col">
            <div name="card_last_digits" id="card_last_digits" class="contenteditable" contenteditable="false" data-validate="require|number" maxlength="30">********{{$billing_info->card_last_digits or "&nbsp"}}</div>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">Expiration Date:</span></div>
          <div class="col-md-9 col">
            <div name="expiration_date" id="expiration_date" class="contenteditable" contenteditable="false"  data-validate="require" >{{$billing_info->expiration_date or "&nbsp"}}</div>
            &nbsp;
            &nbsp;
            <div id="billing_ccv" style="display:none">
              <span > CCV:</span>
              <div name="ccv" class="contenteditable" contenteditable="false" id="ccv_number"  data-validate="require|number" maxlength="30"></div>
            </div>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">Address:</span></div>
          <div class="col-md-9 col">
            <div name="address" class="contenteditable" contenteditable="false" data-validate="require" maxlength="200">{{$billing_info->address or "&nbsp"}}</div>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">City:</span></div>
          <div class="col-md-9 col">
            <div name="city" class="contenteditable" contenteditable="false" data-validate="require" maxlength="200">{{$billing_info->city or "&nbsp"}}</div>
          </div>

          <div class="col-md-3 text-right col"><span class="labeltext">State:</span></div>
          <div class="col-md-9 col">
            <div name="state" class="contenteditable" contenteditable="false" data-validate="require" maxlength="200">{{$billing_info->state or "&nbsp"}}</div>
            &nbsp;
            &nbsp;
            <span >Zipcode:</span>
            <div name="zipcode" class="contenteditable" contenteditable="false" data-validate="require|number" maxlength="5">{{$billing_info->zipcode or "&nbsp"}}</div>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>