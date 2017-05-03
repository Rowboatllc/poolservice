<div class="company_service_offers">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <div class="fieldset" method="POST" action="{{route('dashboard-company-change-services-offer')}}" >
                <div>
                    Choose all of the services that you offer:
                    <span class="glyphicon glyphicon-floppy-save saveform-fieldset icon badge no_display"></span>
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('services[]', 'weekly_cleaning', in_array('weekly_cleaning', $offers)) }}
                        weekly cleaning
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('services[]', 'pool_spa_repair', in_array('pool_spa_repair', $offers)) }}
                        pool or spa repair
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('services[]', 'deep_cleaning', in_array('deep_cleaning', $offers)) }}
                        deep cleaning
                    </label>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>