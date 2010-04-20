function setTOCLocations() {
	try {
		tocLocation = WDN.jQuery('#toc_nav').offset();
		lcLocation = WDN.jQuery('#long_content').offset();
		//WDN.log(tocLocation.top);
	} catch(e) {}
}
WDN.jQuery(document).ready(function($){
	menuFaded = false;
	if (WDN.jQuery('#toc_nav').length > 0) {
		WDN.log('setting TOC');
		setTOCLocations();
	//}
	//if (tocLocation) {
		WDN.jQuery(window).scroll(function(){
			if (WDN.jQuery(window).scrollTop() > (tocLocation.top - 10)) {//when we scroll to the top of the TOC (+padding) then start scrolling the cotents boc
				fadeInTOCMenu();
				menuFaded = true;
			}
			if(WDN.jQuery(window).scrollTop() < (lcLocation.top - 73)) {
				fadeOutTOCMenu();
				menuFaded = false;
			}
		})
		
		if (WDN.jQuery(window).scrollTop() > (tocLocation.top - 10)) {//if the page loads and the top of the window is below the TOC, then show the TOC menu
			fadeInTOCMenu();
			menuFaded = true;
		}
	}
//Move the subhead above the notice
	WDN.jQuery('h2.subhead').insertBefore('#officialMessage');
//Deal with the Table of Contents for the majors pages.
	WDN.jQuery("#toc_nav ol").click(
		function() {
			WDN.jQuery("#toc_nav ol").hide();
		}
	);
	WDN.jQuery("#tocContent, #toc").hover(
		function() {
			WDN.jQuery("#toc_nav ol").show();
			WDN.jQuery("#toc_nav ol a").click(function(event) {
		    	//we need to go to the #ID, but above it by 60 pixels
				var headingTarget = WDN.jQuery(WDN.jQuery(this).attr('href')).offset();
		    	WDN.jQuery(window).scrollTop(headingTarget.top - 60);
		    	fadeInTOCMenu();
				menuFaded = true;
		    	event.preventDefault();
		    });
	    },
	    function() {
	    	WDN.jQuery("#toc_nav ol").hide();
	    }
    );
	WDN.jQuery("#toc_nav ol").hide();
	WDN.jQuery("#toc").tableOfContents(
			WDN.jQuery("#long_content"),      // Scoped to div#long_content
      {
        startLevel: 2,    // H1 and up
        depth:      2,    // H1 through H4,
        topLinks:   false // Add "Top" Links to Each Header
      }
    );
    //End: Deal with the Table of Contents for the majors pages.

    //Deal with the interactivity behind the wdn_notice
	var c = WDN.getCookie('notice');
	if (c) {
		$('#officialMessage').addClass('small');
		$('#officialMessage .minimize').removeClass('minimize').addClass('maximize');
		$("#officialMessage div.message p").hide().children("a").insertAfter("div.message h4").css({'margin-left' : '10px', 'font-size' : '0.8em'});
		setTOCLocations();
	};
	
    $(".minimize, .maximize").click(function() {
    	if ($(this).parent('.wdn_notice').hasClass('small')) { //let's show the full notice
    		$(this).parent(".wdn_notice").fadeOut("fast", function() {
    			$(this).children("div.message").children("a").appendTo("div.message p");
    			$(this).children("div.message").children("p").show().children("a").appendTo("div.message p").css({'margin-left' : '0', 'font-size' : '1em'});
    			$(this).children(".maximize").removeClass("maximize").addClass("minimize");
				$(this).removeClass("small");
    			$(this).fadeIn("fast", function() {
    				setTOCLocations()
    			});
    		});
    	} else {
    		$(this).parent(".wdn_notice").fadeOut("fast", function() { //let's hide the full notice
    			$(this).children("div.message").children("p").hide().children("a").insertAfter("div.message h4").css({'margin-left' : '10px', 'font-size' : '0.8em'});
    			$(this).children(".minimize").removeClass("minimize").addClass("maximize");
				$(this).addClass("small");
    			$(this).fadeIn("fast", function() {
    				setTOCLocations()
    			});
    			WDN.setCookie('notice', 'y', 86400);
    		});
    	}
    	return false;
    });
    //End: Deal with the interactivity behind the wdn_notice
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
    	if($(this).text().length > 4) {
    		$(this).addClass('wide');
    	}
    	if($(this).text().length > 8) {
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
    			WDN.jQuery(this).closest('li').addClass('disabled');
    			return true;
    		}
    	}
    	WDN.jQuery(this).click(function() {
			if (WDN.jQuery(this).hasClass('filterAll')) { //if all was checked, then put the checkmark next to all alls, and show everything.
				if (this.checked){
					WDN.jQuery('#filters input').not('.filterAll').removeAttr('checked');
					WDN.jQuery('.filterAll').attr('checked', 'checked');
					WDN.jQuery('.course').show();
					WDN.jQuery('#majorListing li').show();
				} 
			} else {
				WDN.jQuery('.filterAll').removeAttr('checked'); //uncheck the all checkboxes
				WDN.jQuery('.course').hide(); //hide all the coures
				WDN.jQuery('#majorListing li').hide(); //hide all the major listings
				var one_checked = false;
				WDN.jQuery('#filters input').not('.filterAll').each(function(){ //loop through all the checkboxes
					if (this.checked) {
					    one_checked = true;
						WDN.jQuery('.'+WDN.jQuery(this).attr('value')).show(); //if a checkbox is checked, make sure the corresponding content is shown.
					}
				});
				if (one_checked == false) { //no checkboxes are checked, so show all
				    WDN.jQuery('.course').show();
				    WDN.jQuery('#majorListing li').show();
				    WDN.jQuery('.filterAll').attr('checked', 'checked');
				}
			}
    	});
	});
    $("#maincontent a.course").each(function () {
    	try {
	    	$(this).qtip({
	    		content:{
	    			url: this.href+'?format=partial'
	    		},
	            position : {
	            	corner : {
	            		target : 'topMiddle',
	            		tooltip : 'bottomMiddle'
	            	},
	            	container: $('body'),
	            	adjust : {
	            		screen : true,
	            		y : 3,
	            		x : 5
	            	}
	            },
	            show: {
	            	delay : 150
	            },
	            hide: {
	            	fixed : true,
	            	delay : 150
	            },
	            style: { 
	            	tip: { 
	            		corner: 'bottomMiddle' ,
	            		size: { x: 25, y: 15 },
	            		color: '#c8c8c8'
	            	},
	            	"padding" : "9px",
	            	"width":"598px",
	            	classes : {
	            		tooltip : 'course-qtip'
	            	}
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
    $('#courseSearch, #majorSearch').attr("autocomplete", "off");
    $('#courseSearch').autocomplete({
    	source: function(request, response) {
    		$.ajax({
    			url: UNL_UGB_URL+'courses/search?q='+request.term+'&format=json&limit=10',
    			dataType: "json",
    			success: function(data) {
    				var rows = new Array();
    					for(var i=0; i<data.length; i++){
    						//label is for the suggestion
    						//value is for the input box
    						//key is used to match highlighted course
    						for(var j=0; j<data[i].courseCodes.length; j++){
	    						rows[i] = { 
	    							label: '<dt class="course">' +
		    									'<span class="subjectCode">' + data[i].courseCodes[j].subject + '</span>' +
		    									'<span class="number">' + data[i].courseCodes[j].courseNumber + '</span>' +
		    									'<span class="title">' + data[i].title + '</span>' +
		    									'<span class="key" style="display:none;">' + data[i].courseCodes[j].subject + data[i].courseCodes[j].courseNumber + data[i].title + '</span>' +
	    									'</dt>',
	    							value: data[i].courseCodes[j].subject + " " + data[i].courseCodes[j].courseNumber + ": " + data[i].title,
	    							key: data[i].courseCodes[j].subject + data[i].courseCodes[j].courseNumber + data[i].title
	    						};
    						}
					    }
				    response(rows);
			    }
    		})
    	},
    	focus: function(e, ui) {
    		$('a.indicator').removeClass('indicator');
			$('a:contains("'+ui.item.key+'")').addClass('indicator');
		},
		select: function(e, ui) {
			window.location.href = UNL_UGB_URL+'courses/search?q='+ui.item.value;
		}
    });
    $('#majorSearch').autocomplete({
    	source: function(request, response) {
    		$.ajax({
    			url: UNL_UGB_URL+'major/search?q='+request.term+'&format=json',
    			dataType: "json",
    			success: function(data) {
    				var rows = new Array();
    					for(var i=0; i<data.length; i++){
    						rows[i] = {
    								label : '<span class="format">'+data[i]['title']+'</span>' +
    										'<span class="key" style="display:none;">'+data[i]['title']+i+'</span>',
    								value : data[i]['title'],
    								key : data[i]['title']+i
    						}
					    }
				    response(rows);
			    }
    		})
    	},
    	focus: function(e, ui) {
    		$('a.indicator').removeClass('indicator');
			$('a:contains("'+ui.item.key+'")').addClass('indicator');
		},
		select: function(e, ui) {
			window.location.href = UNL_UGB_URL+'major/'+ui.item.value;
		}
    });
});

function fadeInTOCMenu() {
	if (!menuFaded) { //menu is hidden
		WDN.log('fading menu in');
		WDN.jQuery('#toc_nav').css({'position': 'fixed', 'width': '940px'});
		WDN.jQuery('#toc_major_name').css({'display': 'block'});
		WDN.jQuery('#long_content').css({'margin-top':'73px'});	
		WDN.jQuery('#toc_bar').fadeIn(200);
	}
} 
function fadeOutTOCMenu() {
	if (menuFaded) { //menu is displayed
		WDN.log('fading menu out');
		WDN.jQuery('#toc_nav').css({'position': 'relative', 'width': 'auto'});
		WDN.jQuery('#toc_major_name').css({'display': 'none'});
		WDN.jQuery('#toc_bar').fadeOut(200);
		WDN.jQuery('#long_content').css({'margin-top':'35px'});
	}
} 
