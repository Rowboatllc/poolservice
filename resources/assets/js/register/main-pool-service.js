function validationPoolService()
{
	var form = $( "#frmPoolServiceDashBoard" );
	form.validate({
		rules: {
			'logo':{
				required: true,
			},
            'wq':{
				required: true,
			},
            'driver_license':{
				required: true,
			}
		},
		messages: {
			'logo':{
				required: "Please upload your logo.",
			},
            'wq':{
				required: "Please upload your W-q.",
			},
            'driver_license':{
				required: "Please upload your Driver License.",
			}
		},
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
		unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
	});	
}

var _URL = window.URL || window.webkitURL;
function displayPreview(files,id) {
    var img = new Image();
    
    img.onload = function () {
            var imgsrc=this.src;        
                doSomething(imgsrc,id); //call function
            };   
    img.src = _URL.createObjectURL(files);
}

// Do what you want in this function
function doSomething(imgsrc,id)
{
    $("#"+id+" img").remove();
    $('#'+id+'').append('<img src="'+imgsrc+'">'); 
}

$(document).ready(function() {

    validationPoolService();
    // next info
	$('.btn-next-info').on('click', function(e) {
        if($( "#frmPoolServiceDashBoard" ).valid()) {
            e.preventDefault();
            var current_active_step = $(this).parents('.f2').find('.list-group-item.active').next();
            current_active_step.siblings('a.active').removeClass("active");
            current_active_step.addClass("active");
            var index = current_active_step.index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        }
    });

    $("#file_logo").on('change',function () 
    {        
        var file = this.files[0];
        displayPreview(file,'preview_logo');
    });

    $("#file_wq").on('change',function () 
    {        
        var file = this.files[0];
        displayPreview(file,'preview_wq');
    });

    $("#file_driven_license").on('change',function () 
    {        
        var file = this.files[0];
        displayPreview(file,'preview_driven_license');
    });

    $("#file_cpa").on('change',function () 
    {        
        var file = this.files[0];
        displayPreview(file,'preview_cpa');
    });

    // back info
	$('.btn-previous').on('click', function(e) {
        e.preventDefault();
        var current_active_step = $(this).parents('.f2').find('.list-group-item.active').prev();
        current_active_step.siblings('a.active').removeClass("active");
        current_active_step.addClass("active");
        var index = current_active_step.index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });

    $('.btn-submit').on('click', function(e) {
        e.preventDefault();
        var frm = $('#frmPoolServiceDashBoard');
        var data = new FormData(frm[0]);
        var xhr = new XMLHttpRequest();
        (xhr.upload || xhr).addEventListener('progress', function(e) {
            var done = e.position || e.loaded
            var total = e.totalSize || e.total;
            console.log('xhr progress: ' + Math.round(done/total*100) + '%');
        });
        xhr.addEventListener('load', function(e) {
            console.log('xhr upload complete', e, this.responseText);
        });
        var token = $("meta[name='csrf-token']").attr("content");        
        xhr.open('POST', frm.attr('action'), true);
        xhr.onprogress = function () {
            $("#divModelPoolService").css("display", "block");
        };
        xhr.setRequestHeader("X-CSRF-Token", token);        
        
        xhr.onreadystatechange = function () {
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                console.log(xhr.responseText); 
                var data=JSON.parse(xhr.responseText);
                var img=$('#preview_logo img');
                $('.logo-data').append(img);
                //load select box
                $('#review_select').append($('<option>').append('<li>W-q <i class="fa fa-car"></i></li>'));
                $('#review_select').append($('<option>').append("<li>Driver's-License <i class='fa fa-car'></i></li>"));
                $('#review_select').append($('<option>').append("<li>CPA Certification <i class='fa fa-car'></i></li>"));
                //load pool-service info
                var table=$('.address-data #infoTable');                
                var row="<tr>";
                row+="<td>Company Name</td>";
                row+="<td>"+data.message.name+"</td>";
                row+="</tr>";
                row+="<tr>";
                row+="<td>Website</td>";
                row+="<td>"+data.message.website+"</td>";
                row+="</tr>";
                row+="<tr>";
                row+="<td>First and last name</td>";
                row+="<td>"+data.message.fullname+"</td>";
                row+="</tr>";
                row+="<tr>";
                row+="<td>Address</td>";
                row+="<td>"+data.message.address+"</td>";
                row+="</tr>";
                row+="<tr>";
                row+="<td>Telephone Number</td>";
                row+="<td>"+data.message.phone+"</td>";
                row+="</tr>";
                row+="</table>";
                table.append(row);
                $('.sectionC1').addClass('divLoadData');   
                $('.sectionC2').removeClass('divLoadData');
            }

            $("#divModelPoolService").css("display", "none");
        };

        xhr.send(data);        
    });

    // routes tab
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});