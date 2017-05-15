@extends('layouts.template')

@section('content')
<div class="container panel dashboard">
    <div class="box-body no-padding dashboard-notification content-block">
        <div class="table-responsive" data-totalpage="{{ceil($notifications->total()/$notifications->perPage())}}" data-page="{{$notifications->currentPage()}}" data-url="{{ route('dashboard-notification-get-list') }}" >
            <table class="table table-hover table-list" data-getitemurl="{{ route('dashboard-notification-get-item') }}"  data-updateurl="{{ route('dashboard-company-save-technician') }}" data-removeurl="{{ route('dashboard-notification-remove-item') }}" >
                <tr>
                    <th></th>
                    <th><span data-orderfield="id">Id</span></th>
                    <th><span data-orderfield="subject">Subject</span></th>
                    <th></th>
                </tr>
                @foreach ($notifications as $item)
                    <tr class="{{ $item->opened=='0' ? 'notopened' : '' }}">	
                        <td></td>
                        <td>{{$item->id}}</td>
                        <td>{{$item->subject}}</td>
                        <td>
                            <span class="glyphicon glyphicon-trash icon remove-item-list" aria-hidden="true" data-id="{{$item->id}}"></span>
                        </td>
                    </tr>
                @endforeach
            </table>
            <ul class="pagination"></ul>
            <script type="text/x-jquery-tmpl">
                <tr class="">	
                    <td></td>
                    <td>${id}</td>
                    <td>${subject}</td>
                    <td>
                        <span class="glyphicon glyphicon-trash icon remove-item-list" aria-hidden="true" data-id="${id}"></span>
                    </td>
                </tr>
            </script>
        </div>
        
    </div>
</div>
<script type="text/javascript" src="{{ config('app.url') }}js/lib/jquery.tmpl.js" ></script>
@endsection