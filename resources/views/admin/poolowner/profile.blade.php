<div class="poolowner_profile">
    <form action="{{ route('admin-poolowner-profile') }}" method="POST" />
        {{ Form::text('email', $profile->email, array_merge(['class' => 'form-control', 'placeholder'=>'email'], [])) }}
        {{ Form::text('fullname', $profile->fullname, array_merge(['class' => 'form-control', 'placeholder'=>'fullname'], [])) }}
        {{ Form::text('address', $profile->address, array_merge(['class' => 'form-control', 'placeholder'=>'address'], [])) }}
        {{ Form::text('city', $profile->city, array_merge(['class' => 'form-control', 'placeholder'=>'city'], [])) }}
        {{ Form::text('zipcode', $profile->zipcode, array_merge(['class' => 'form-control', 'placeholder'=>'zipcode'], [])) }}
        {{ Form::text('telephone', $profile->phone, array_merge(['class' => 'form-control', 'placeholder'=>'phone'], [])) }}
        {{ Form::select('state', $profile->codes, $profile->zipcode, array_merge(['class' => 'form-control', 'placeholder'=>'phone'], [])) }}
        <span class="glyphicon glyphicon-ok save_form"></span>
    </form>
</div>