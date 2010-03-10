WDN.jQuery(document).ready(function($){
	WDN.jQuery(window).scroll(function(){
		//alert(WDN.jQuery(window).scrollTop());
		var tocLocation = WDN.jQuery('#toc_nav').offset();
		var lcLocation = WDN.jQuery('#long_content').offset();
		if (WDN.jQuery(window).scrollTop() >= (tocLocation.top - 10)) {//when we scroll to the top of the TOC (+padding) then start scrolling the cotents boc
			WDN.jQuery('#toc_nav').css({'position': 'fixed'});
			WDN.jQuery('#long_content').css({'margin-top':'73px'});		
		}
		if(WDN.jQuery(window).scrollTop() <= (lcLocation.top - 70)) {
			WDN.jQuery('#toc_nav').css({'position': 'relative'});
			WDN.jQuery('#long_content').css({'margin-top':'35px'});	
		}
	})
//Deal with the Table of Contents for the majors pages.
	$("#toc_nav ol").click(
		function() {
			$("#toc_nav ol").hide();
		}
	);
    $("#toc_nav").hover(
		function() {
	        $("#toc_nav ol").show();
	    },
	    function() {
	        $("#toc_nav ol").hide();
	    }
    );
    $("#toc_nav ol").hide();
    $("#toc").tableOfContents(
    		$("#long_content"),      // Scoped to div#long_content
      {
        startLevel: 2,    // H1 and up
        depth:      2,    // H1 through H4,
        topLinks:   false // Add "Top" Links to Each Header
      }
    );
    //End: Deal with the Table of Contents for the majors pages.

    //Deal with the interactivity behind the wdn_notice
    $(".minimize").click(function() {
    	$(this).parent(".wdn_notice").slideUp("slow", function() {
    			$(this).wrap("<div class='col right' id='wdn_notice_wrapper'></div>"); //wrap in a col, floated right
    			$(this).children("div.message").children("p").children("a").insertAfter("div.message p").siblings("p").hide();
    			$(this).children(".minimize").removeClass("minimize").addClass("maximize");
    			$(this).slideDown("slow");
    	});
    	return false;
    });
    //End: Deal with the interactivity behind the wdn_notice
    
    $('#maincontent a.course').click(function(eventObject){
    	$(this).colorbox({width:"640px",href:this.href+'?format=partial',open:true});
    	eventObject.preventDefault();
    });
    //Show/Hide the course information
    $('#toggleAllCourseDescriptions').click(function() {
    	$('dd').slideToggle();
    	$('#maincontent .title a').toggleClass('showIt');
    	return false;
    });
    $('#maincontent .title a').click(function() {
    	$(this).parent('span').parent('dt').next('dd').slideToggle();
    	$(this).toggleClass('showIt');
    	return false;
    });
  //Deal with the course call numbers that are long
    $('.number').each(function(){
    	if($(this).text().length > 3) {
    		$(this).addClass('wide');
    	}
    	if($(this).text().length > 7) {
    		$(this).addClass('really');
    	}
    });
    
    // Configure course filters.
//    $('#filters input').click(function(){
//    	if (this.checked) {
//    		$('.'+this.value).show();
//    		//$('dt.'+this.value).addClass("revealed");
//    	} else {
//    		$('.'+this.value).slideUp(600);
//    	}
//    });
    WDN.jQuery('#filters input').each(function(){
    	if (WDN.jQuery(this).attr('value') !== "all") {
    		// Check and see if we actually have any of these courses
    		if (WDN.jQuery('.'+WDN.jQuery(this).attr('value')).length == 0) {
    			WDN.jQuery(this).attr('disabled', 'disabled');
    			return;
    		}
    	}
    	WDN.jQuery(this).click(function() {
			if (WDN.jQuery(this).attr('value') === "all") {
				if (this.checked){
					WDN.jQuery('#filters input').not('#filterAll').removeAttr('checked');
					WDN.jQuery('.course').show();
				} 
			} else {
					WDN.jQuery('#filterAll').removeAttr('checked');
					WDN.jQuery('#filters input').not('#filterAll').each(function(){
						if(this.checked){
							WDN.jQuery('.'+WDN.jQuery(this).attr('value')).show();
						} else {
							WDN.jQuery('.'+WDN.jQuery(this).attr('value')).hide();
						}
					});
			}
    	});
	});
    /*
    $("#cboxContent").delegate("a.course","click",function (e) {
    	e.preventDefault();
    	$(this).colorbox({width:"640px",href:this.href+'?format=partial',open:true});
    });
    */
    
    $("#maincontent a.course").each(function () {
    	try {
	    	$(this).qtip({
	    		content:{
	    			url: this.href+'?format=partial'
	    		},
	            style:{
	    			"width":"598px"
	            }
	    	});
	    	$(this).qtip("api").beforeShow = function(){
	    	    // Check the content
	    	    if ($('div[qtip='+this.id+'] div.qtip-content dt').length == 0) {
	    	        $('div[qtip='+this.id+']').css({width:'120px'});
	    	        $('div[qtip='+this.id+'] div.qtip-content').html('<p>Could not find that course.</p>');
	    	    }
	    	    return true;
	    	};
    	} catch(e) {}
    }); 
});

function setMenuOffset() {
	var header = document.getElementById('toc_nav');
	var longContentPlace = document.getElementById('long_content').offsetTop;
	//alert(longContentPlace);
	if (!header) return;
	var currentOffset = document.documentElement.scrollTop || document.body.scrollTop; // body for Safari
	var startPos = parseInt(setMenuOffset.initialPos) || longContentPlace;
	var desiredOffset = startPos - currentOffset;
	if (desiredOffset < 10)
	desiredOffset = 10;
	if (desiredOffset != parseInt(header.style.top))
	header.style.top = desiredOffset + 'px';
} 
