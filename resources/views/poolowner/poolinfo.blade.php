<div class="poolowner_poolinfo">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <div class="fieldset" method="POST" action="{{route('admin-save-poolowner-poolinfo')}}" >
                <div class="checkbox">
                    <label><input data-child=".rdo_weekly_pool" name="is-pool[]" type="checkbox" class="is-pool" value="pool">Pool</label>
                    <span class="glyphicon glyphicon-floppy-save saveform-fieldset icon badge no_display"></span>
                </div>
                <div class="radio" data-parent=".is-pool">
                    <label><input data-parent=".is-pool" type="radio" name="watertype_weekly_pool" class="rdo_weekly_pool" value="salt">Saltwater</label>
                </div>
                <div class="radio">
                    <label><input data-parent=".is-pool" type="radio" name="watertype_weekly_pool" class="rdo_weekly_pool" value="chlorine">Chlorine</label>
                </div>
                
                <div class="checkbox">
                    <label><input name="is-pool[]" type="checkbox" value="spa">Spa</label>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>