<div class="box-body no-padding company-customer content-block">
    @if (count($technicians) == 0)
        You currently have no customer
    @else
    <div class="table-responsive" data-totalpage="{{ceil($customers->total()/$customers->perPage())}}" data-page="{{$customers->currentPage()}}" data-url="{{ route('dashboard-company-list-customer') }}" >
        <div class="search-fieldset">
            <input name="searchvalue" class="form-control" />
            <select name="searchfield" class="form-control">
                <option value="">Filter</option>
                <option value="city">City</option>
                <option value="state">State</option>
                <option value="fullname">Name</option>
                <option value="profiles.created_at">Date sign up</option>
                <option value="lastserveddate">Date of last service</option>
                <option value="profiles.zipcode">Zipcode</option>
            </select>
            <span class="btn btn-primary glyphicon glyphicon-search search"></span>
            <span class="btn btn-primary glyphicon glyphicon-filter clear-filter"></span>
        </div>
        <table class="table table-hover table-list">
            <tr>
                <th width=""><span data-orderfield="fullname">Name</span></th>
                <th width=""><span data-orderfield="address">Street Address</span></th>
                <th width=""><span data-orderfield="zipcode">Zipcode</span></th>
                <th width=""><span data-orderfield="city">City</span></th>
                <th width=""><span data-orderfield="state">State</span></th>
                <th width=""><span data-orderfield="nextserveddate">Next Service Date</span></th>
                <th width=""><span data-orderfield="lastserveddate">Last service Date</span></th>
                <th width=""><span data-orderfield="created_at">Sign up Date</span></th>
            </tr>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{$customer->fullname}}</td>
                    <td>{{$customer->address}}</td>
                    <td>{{$customer->zipcode}}</td>
                    <td>{{$customer->city}}</td>
                    <td>{{$customer->state}}</td>
                    <td>{{$customer->nextserveddate}}</td>
                    <td>{{$customer->lastserveddate}}</td>
                    <td>{{$customer->created_at}}</td>
                </tr>
            @endforeach
        </table>
        <ul class="pagination"></ul>
        <script type="text/x-jquery-tmpl">
            <tr>
                <td>${fullname}</td>
                <td>${address}</td>
                <td>${zipcode}</td>
                <td>${city}</td>
                <td>${state}</td>
                <td>${nextserveddate}</td>
                <td>${lastserveddate}</td>
                <td>${created_at}</td>
            </tr>
        </script>
    </div>
    @endif
</div>
<script type="text/javascript" src="{{ config('app.url') }}js/lib/jquery.tmpl.js" ></script>