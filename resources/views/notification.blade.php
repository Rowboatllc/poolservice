@extends('layouts.dashboard.template')
@section('content')
<div class="container panel dashboard">
    <div class="box-body no-padding dashboard-notification content-block">
        @if (count($notifications) != 0)
        <div class="table-responsive" data-totalpage="{{ceil($notifications->total()/$notifications->perPage())}}" data-page="{{$notifications->currentPage()}}" data-url="{{ route('dashboard-notification-get-list') }}" >
            <table class="table table-hover table-list" data-getitemurl="{{ route('dashboard-notification-get-item') }}"  data-updateurl="{{ route('dashboard-company-save-technician') }}" data-removeurl="{{ route('dashboard-notification-remove-item') }}" >
                <tr>
                    <th></th>
                    <th width="10%"><span data-orderfield="id"></span></th>
                    <th width="60%"><span data-orderfield="subject">Subject</span></th>
                    <th width="20%"><span data-orderfield="created_at">Date</span></th>
                    <th width="10%"></th>
                </tr>
                @foreach ($notifications as $item)
                    <tr class="{{ $item->opened=='0' ? 'notopened' : '' }}">
                        <td></td>       
                        <td> <span class="avatar" style="background-image: url({{ config('filesystems.disks.uploads.url') }}{{$item->avatar}})"></span> </td>
                        <td>{{$item->subject}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <span class="glyphicon glyphicon-trash icon remove-item-list" aria-hidden="true" data-id="{{$item->id}}"></span>
                            <span class="glyphicon glyphicon-eye-open icon view-item-list" aria-hidden="true" data-id="{{$item->id}}"></span>
                        </td>
                    </tr>
                @endforeach
            </table>
            <ul class="pagination"></ul>
            <script type="text/x-jquery-tmpl">
                <tr class="">	
                    <td></td>
                    <td> <span class="avatar" style="background-image: url({{ config('filesystems.disks.uploads.url') }}${avatar})"></span> </td>
                    <td>${subject}</td>
                    <td>${created_at}</td>
                    <td>
                        <span class="glyphicon glyphicon-trash icon remove-item-list" aria-hidden="true" data-id="${id}"></span>
                        <span class="glyphicon glyphicon-eye-open icon view-item-list" aria-hidden="true" data-id="${id}"></span>
                    </td>
                </tr>
            </script>
        </div>
        <div class="modal fade notification-serviceModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close" data-dismiss="modal">&times;</span>
                        <h4 class="modal-title"><span name="subject"></span></h4>
                    </div>
                    <div class="modal-body">
                        <span name="content"></span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection