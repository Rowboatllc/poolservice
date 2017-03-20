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
  <h2>Pool service</h2>
  <p>To make the tabs toggleable, add the data-toggle="tab" attribute to each link. Then add a .tab-pane class with a unique ID for every tab and wrap them inside a div element with class .tab-content.</p>

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
    <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>
<script>
    // $(function() {
    //     $(".nexttab").click(function() {
    //         alert('hahahahahahaha');
    //     });
    // })
    // var validator = $("#myForm").validate();
    
    // var tabs = $("#tabs").tabs({
    //     select: function(event, ui) {
    //         alert('hahahahahahaha');
    //         var valid = true;
    //         var current = $(this).tabs("option", "selected");
    //         var panelId = $("#tabs ul a").eq(current).attr("href");
            
    //         $(panelId).find("input").each(function() {
    //             console.log(valid);
    //             if (!validator.element(this) && valid) {
    //                 valid = false;
    //             }
    //         });

    //         return valid;
    //     }
    // });


    // $(".nexttab").click(function() {
    //     alert('hahahahahahaha1');
    //     $("#tabs").tabs("select", this.hash);
    // });

    // //use link to submit form instead of button
    // $("a[id=submit]").click(function() {
    //     alert('hahahahahahaha2');
    //     $(this).parents("form").submit();
    // });
    // $( "#tabs" ).tabs();
</script>
@endsection




