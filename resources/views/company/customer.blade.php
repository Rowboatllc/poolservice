<div class="box-body table-responsive no-padding company-customer">
    <table class="table table-hover">
        <tr>
            <th><a style='cursor:pointer;'>Customer</a></th>
            <th><a style='cursor:pointer;'>Full name</a></th>
            <th><a style='cursor:pointer;'>Phone</a></th>
            <th><a style='cursor:pointer;'>Address</a></th>
        </tr>
        @foreach ($customers as $customer)
            <tr>	
                <td valign="middle"><img class="logo" src='{{$customer->avatar}}' width='100' /></td>
                <td valign="middle">{{$customer->fullname}}</td>
                <td valign="middle">{{$customer->phone}}</td>
                <td valign="middle">
                    {{$customer->address}}
                </td>
            </tr>
        @endforeach
    </table>
</div>