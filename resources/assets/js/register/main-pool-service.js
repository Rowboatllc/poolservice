function validationPoolService()
{
	let form = $( "#frmPoolServiceDashBoard" );
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

let _URL = window.URL || window.webkitURL;
function displayPreview(files,id) {
    let img = new Image();
    
    img.onload = function () {
            let imgsrc=this.src;        
                loadImage(imgsrc,id); //call function
            };   
    img.src = _URL.createObjectURL(files);
}

// Do what you want in this function
function loadImage(imgsrc,id)
{
    $("#"+id+" img").remove();
    $('#'+id+'').append('<img src="'+imgsrc+'">'); 
}

$(document).ready(function() {
    validationPoolService();
    $.widget( "custom.iconselectmenu", $.ui.selectmenu, {
      _renderItem: function( ul, item ) {
        let li = $( "<li>" ),
          wrapper = $( "<div>", { text: item.label } );
 
        if ( item.disabled ) {
          li.addClass( "ui-state-disabled" );
        }
 
        $( "<span>", {
          style: item.element.attr( "data-style" ),
          "class": "ui-icon " + item.element.attr( "data-class" )
        }).appendTo( wrapper );
 
        return li.append( wrapper ).appendTo( ul );
      }
    });
 
    $( "#review_select" )
      .iconselectmenu()
      .iconselectmenu( "menuWidget" )
        .addClass( "ui-menu-icons" );
    
    // next info
	$('.btn-next-info').on('click', function(e) {
        if($( "#frmPoolServiceDashBoard" ).valid()) {
            e.preventDefault();
            let current_active_step = $(this).parents('.f2').find('.list-group-item.active').next();
            current_active_step.siblings('a.active').removeClass("active");
            current_active_step.addClass("active");
            let index = current_active_step.index();
            $("div.profile-tab>div.profile-tab-content").removeClass("active");
            $("div.profile-tab>div.profile-tab-content").eq(index).addClass("active");
        }
    });

    $("#file_logo").on('change',function () 
    {        
        let file = this.files[0];
        displayPreview(file,'preview_logo');
    });

    $("#file_wq").on('change',function () 
    {        
        let file = this.files[0];
        displayPreview(file,'preview_wq');
    });

    $("#file_driven_license").on('change',function () 
    {        
        let file = this.files[0];
        displayPreview(file,'preview_driven_license');
    });

    $("#file_cpa").on('change',function () 
    {        
        let file = this.files[0];
        displayPreview(file,'preview_cpa');
    });

    // back info
	$('.btn-previous').on('click', function(e) {
        e.preventDefault();
        let current_active_step = $(this).parents('.f2').find('.list-group-item.active').prev();
        current_active_step.siblings('a.active').removeClass("active");
        current_active_step.addClass("active");
        let index = current_active_step.index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });

    $('.btn-submit').on('click', function(e) {
        e.preventDefault();
        let frm = $('#frmPoolServiceDashBoard');
        let data = new FormData(frm[0]);
        let xhr = new XMLHttpRequest();
        (xhr.upload || xhr).addEventListener('progress', function(e) {
            let done = e.position || e.loaded
            let total = e.totalSize || e.total;
            console.log('xhr progress: ' + Math.round(done/total*100) + '%');
        });
        xhr.addEventListener('load', function(e) {
            console.log('xhr upload complete', e, this.responseText);
        });
        let token = $("meta[name='csrf-token']").attr("content");        
        xhr.open('POST', frm.attr('action'), true);
        xhr.onprogress = function () {
            $("#divModelPoolService").css("display", "block");
        };
        xhr.setRequestHeader("X-CSRF-Token", token);        
        
        xhr.onreadystatechange = function () {
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                console.log(xhr.responseText); 
                let data=JSON.parse(xhr.responseText);
                let img=$('#preview_logo img');
                $('.logo-data').empty().append(img);
                //load select box
                $('#review_select').empty().append($('<option>').append('<li>Awaiting Verification</li>'));
                $('#review_select').append($('<option>').append('<li>W-q <i class="fa fa-car"></i></li>'));                
                $('#review_select').append($('<option>').append("<li>Driver's-License <i class='fa fa-car'></i></li>"));
                $('#review_select').append($('<option>').append("<li>CPA Certification <i class='fa fa-car'></i></li>"));
                //load pool-service info
                $('.address-data #infoTable tr').remove();
                let table=$('.address-data #infoTable');                
                let row="<tr>";
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
    $(".sectionB1 div.route-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        let index = $(this).index();
        $("div.route-tab>div.route-tab-content").removeClass("active");
        $("div.route-tab>div.route-tab-content").eq(index).addClass("active");
    });

    $('.company-route-service select').on('change', function(e) {
        let date=this.id;
        $.ajax({ 
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "load-pool-owner",
            method: "GET",
            data: { id : this.value,date:date},
            success: function (data) {
                if(data.success===true)
                {
                    $('#count_route').text(data.message.length + " pools");
                    $('.table-route-'+date+' tbody tr').remove();
                    let table=$('.table-route-'+date+' tbody');

                    jQuery.each(data.message, function(index, item) {
                        let n=parseInt(index) +1;
                        let row="<tr>";
                        row+="<td><input type='checkbox' checked></input></td>";
                        row+="<td>"+ n +"</td>";
                        row+="<td>"+item.address+"</td>";
                        row+="<td>"+item.city+"</td>";
                        row+="<td>"+item.zipcode+"</td>";
                        row+="</tr>";

                        table.append(row);
                    });
                }
            },
            error: function (ajaxContext) {
                console.log(ajaxContext.responseText);
            }
        });	
    })

    $('.chk-not-available').on('change',function(e){
        let date=$(this).attr('date');
        if($(this).prop('checked')){            
            $('.avatar-'+date+'').addClass('hidden');
            $('.name-'+date+'').addClass('hidden');
            $('.not-asign-'+date+'').removeClass('hidden');
            $('.table-route-'+date+' input[type="checkbox"]').prop('checked', false);
        }else{
            $('.avatar-'+date+'').removeClass('hidden');
            $('.name-'+date+'').removeClass('hidden');
            $('.not-asign-'+date+'').addClass('hidden');
            $('.table-route-'+date+' input[type="checkbox"]').prop('checked', true);
        }        
    });
});