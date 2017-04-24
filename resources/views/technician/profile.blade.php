 <div class="poolowner_profile">
    <div class="row">
        <div class="col-md-4 text-right">
            <div class="fieldset">
                <img class="img_profile" src="{{$company->logo}}" style=" width: 300px; height: 150px; " />
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-8">

            <div class="row">
                <div class="col-md-3 text-right col"> <span class="labeltext">My name:</span> </div>
                <div class="col-md-9 col">
                    {{ $user->name }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-right col"> <span class="labeltext">Company name:</span> </div>
                <div class="col-md-9 col">
                    {{ $company->name }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-right col"> <span class="labeltext">Email:</span> </div>
                <div class="col-md-9 col">
                    {{ $company->email }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-right col"> <span class="labeltext">Address:</span> </div>
                <div class="col-md-9 col">
                    {{ $company->address }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-right col"> <span class="labeltext">State:</span> </div>
                <div class="col-md-9 col">
                    {{ $company->state }}, Zipcode: {{ $company->zipcode }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-right col"> <span class="labeltext">Phone:</span> </div>
                <div class="col-md-9 col">
                    {{ $company->phone }}
                </div>
            </div>
        </div>
    </div>
</div>