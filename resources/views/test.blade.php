@extends('layouts.template')

@section('content')
<div class="panel panel-default panel-service">
    <div class="container">
        <div class="row row-eq-height">

            <div class="container">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href=".tab1">Tab 1</a></li>
                    <li><a data-toggle="pill" href=".tab2">Tab 2</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab1 tab-pane fade in active">
                        <h3>Tab 1</h3>
                        <div class="tab1content">
                            <form action="{{ route('nthere') }}" method="post" onsubmit="return false;" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input name="param_abc" type="text" placeholder="abc" />
                                <input name="param_edf" type="text" placeholder="edf" />
                                <input name="paramkey" type="hidden" value="ohohohoho" />
                                <input name="ssssssss" type="text" placeholder="edf" />
                                
                                <button class="saveParam">Save</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab2 tab-pane fade">
                        <h3>Tab 2</h3>
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</div>
@endsection


