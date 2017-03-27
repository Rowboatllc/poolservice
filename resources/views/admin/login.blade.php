@extends('layouts.admin.template')

@section('content')

<div class="panel panel-default panel-transparent">
    <div class="container">
        <div class="row an_option">
            <div class="">
                {{ csrf_field() }}
                <input type="input" name="email" placeholder="email" />
                <input type="input" name="password" placeholder="passsword" />
                <button type="submit" class="btn btn_primary btn-login">login</button>
            </div>
        </div>
        <div class="row text-right">
            <button type="submit" class="btn btn_primary add_new">Add new</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        
        $('.btn-login').on('click', function () {
            //console.log('do sth here');
            login($(this).parent());
        });

        function login(obj) {
            jQuery.ajax({
                url: "{{ route('admin-dologin') }}",
                method: "POST",
                data: $(obj).find('input').serialize(),
                dataType: "application/json",
                success: function (result) {
                    console.log(result);
                }
            });
        }
        
    });
</script>
@endsection