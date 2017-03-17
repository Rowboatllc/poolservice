@extends('layouts.app')

@section('content')
<!--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="cmxform" id="myForm" method="post" action="">
                <div id="tabs">
                    <ul>
                        <li><a href="#general">General</a></li>
                        <li><a href="#tab2">Specifics</a></li>
                    </ul>
                    
                    <div id="general">
                        <label>First name</label>
                        <input id="first" class="required" name="first" />
                        <label>Last name</label>
                        <input id="last" name="last" />
                        <p>
                            <a class="nexttab navbutton" href="#tab2"><span>Next</span></a>  
                        </p>
                    </div>
                    <div id="tab2">
                        <h2>Tab2</h2>
                        <label>Middle name</label>
                        <input id="middle" class="required" name="middle" />
                        <p>
                            <a class="nexttab navbutton" href="#general"><span>Prev</span></a>
                            <a class="submit navbutton" id="submit" href="#"><span>Submit</span></a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>-->


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
<div>
        <div id="tabs">
        <ul>
            <li><a href="#fragment-1"><span>One</span></a></li>
            <li><a href="#fragment-2"><span>Two</span></a></li>
            <li><a href="#fragment-3"><span>Three</span></a></li>
        </ul>
        <div id="fragment-1">
            <p>First tab is active by default:</p>
            <pre><code>$( "#tabs" ).tabs(); </code></pre>
        </div>
        <div id="fragment-2">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        </div>
        <div id="fragment-3">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        </div>
    </div>
 </div>
    </div>
</div>
<script>
    $( "#tabs" ).tabs();
</script>
@endsection




