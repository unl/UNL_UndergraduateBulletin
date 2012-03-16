function setTOCLocations() {
	try {
		tocLocation = WDN.jQuery('#toc_nav').offset();
		lcLocation = WDN.jQuery('#long_content').offset();
		//WDN.log(tocLocation.top);
	} catch(e) {}
}
WDN.jQuery(document).ready(function($){
//Move the subhead above the notice
	WDN.jQuery('h2.subhead').insertBefore('#officialMessage');
	
//Deal with the Versioning controls
	var setSessionCookie = function(name, value) {
		var path = '/';
		document.cookie = name + "=" + value + ";path=" + path;
	};
	WDN.jQuery('#versioning .action').click(function(){
		if (WDN.jQuery(this).hasClass('opened')) {
			setSessionCookie("va", "closed");
		} else {
			setSessionCookie("va", "opened");
		}
		WDN.jQuery('#versioning .content').toggle('slide', {percent : 0, direction : 'right'}, 500, function(){
			WDN.jQuery('#versioning .action').toggleClass('opened');
		});
		return false;
	});
	var va = WDN.getCookie('va');
	if(va=='closed'){
		WDN.jQuery('#versioning .action').click();
	}
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
				window.location.hash = WDN.jQuery(this).attr('href');
				accomodateHash();
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
        topLinks:   false, // Add "Top" Links to Each Header
        callback : function() {
				if (window.location.hash) {
					accomodateHash();
				}
			}
      }
    );
	menuFaded = false;
	if (WDN.jQuery('#toc_nav').length > 0) {
		WDN.log('setting TOC');
		setTOCLocations();
	
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
		//deal with small window heights and large toc height
		WDN.log (WDN.jQuery('#toc').height());
		WDN.log ((WDN.jQuery(window).height() * 0.85));
		if (WDN.jQuery('#toc').height() > (WDN.jQuery(window).height() * 0.85)) {
			WDN.jQuery('#toc').css({'max-height' : WDN.jQuery(window).height() * 0.85, 'overflow-y' : 'scroll', '-ms-overflow-y' : 'scroll'})
		}
	}
    //End: Deal with the Table of Contents for the majors pages.

    //Deal with the interactivity behind the wdn_notice
	var c = WDN.getCookie('notice');
	if (c) {
		$('#officialMessage').addClass('small');
		$('#officialMessage .minimize').removeClass('minimize').addClass('maximize');
		$("#officialMessage div.message p, #previousBulletins").hide();
		$("#bulletinRules").insertAfter("#officialMessage div.message h4").css({'margin-left' : '10px', 'font-size' : '0.8em'});
		setTOCLocations();
	};
	
    $("#officialMessage .minimize, #officialMessage .maximize").click(function() {
    	if ($(this).parent('.wdn_notice').hasClass('small')) { //let's show the full notice
    		$(this).parent(".wdn_notice").fadeOut("fast", function() {
    			$(this).children("div.message").children("a").appendTo("div.message p");
    			$("#officialMessage div.message").children("h4, #previousBulletins").show();
    			$("#officialMessage div.message p").show();
    			$("#bulletinRules").appendTo("div.message p").css({'margin-left' : '0', 'font-size' : '1em'});
    			$(this).children(".maximize").removeClass("maximize").addClass("minimize");
				$(this).removeClass("small");
    			$(this).fadeIn("fast", function() {
    				setTOCLocations()
    			});
    		});
    	} else {
    		$(this).parent(".wdn_notice").fadeOut("fast", function() { //let's hide the full notice
    			$(this).children("div.message").children("h4, #previousBulletins").hide();
    			$("#officialMessage div.message p").hide();
    			$("#bulletinRules").insertAfter("div.message h4").css({'margin-left' : '10px', 'font-size' : '0.8em'});
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
    WDN.jQuery('h2.resultCount').after('<p id="filterSummary">Displaying: <a href="#" class="all">All Options</a></p>');
    WDN.jQuery('form.filters input').each(function(){
    	if (WDN.jQuery(this).attr('value') !== "all") {
    		// Check and see if we actually have any of these courses
    		var total = WDN.jQuery('.'+WDN.jQuery(this).attr('value')).length; //count all based on class
    		if (total == 0) {
    			WDN.jQuery(this).attr('disabled', 'disabled'); //disable the input/label
    			WDN.jQuery(this).closest('li').addClass('disabled');
    			return true;
    		} else {
    			if (WDN.jQuery(this).closest('form').hasClass('courseFilters')) { //otherwise calculate the count
        			total = total/2;
        		}
    			WDN.jQuery('label[for='+this.id+']').append(' <span class="count">('+total+')</span>'); // add the count
    		}
    	}
    	WDN.jQuery(this).click(function() {
    		if (WDN.jQuery(this).hasClass('filterAll')) { //if all was checked, then put the checkmark next to all alls, and show everything.
				if (this.checked){
					WDN.jQuery('form.filters input').not('.filterAll').removeAttr('checked');
					WDN.jQuery('.filterAll').attr('checked', 'checked');
					WDN.jQuery('dd.course, dt.course, #majorListing li').show();
					WDN.jQuery('#filterSummary a').remove();
					WDN.jQuery('#filterSummary').append('<a href="#" class="all">All Options</a>');
					WDN.jQuery('h2.resultCount span').remove();
				}
			} else {
				WDN.jQuery('.filterAll').removeAttr('checked'); //uncheck the all checkboxes
				WDN.jQuery('dd.course, dt.course, #majorListing li').hide(); //hide all the coures and majors
				var one_checked = false;
				WDN.jQuery('#filterSummary a').remove();
				WDN.jQuery('form.filters input').not('.filterAll').each(function(){ //loop through all the checkboxes
					if (this.checked) {
					    one_checked = true;
						WDN.jQuery('li.'+WDN.jQuery(this).attr('value')+', dd.'+WDN.jQuery(this).attr('value')+', dt.'+WDN.jQuery(this).attr('value')).show(); //if a checkbox is checked, make sure the corresponding content is shown.
						WDN.jQuery('#filterSummary a.all').remove();
						//WDN.jQuery('#filterSummary').append(' <a href="#" class="'+WDN.jQuery(this).attr('value')+'"><span class="group">'+WDN.jQuery(this).closest('fieldset').children('legend').text()+':</span> '+WDN.jQuery(this).siblings('label')[0].childNodes[0].nodeValue+'</a>')
						WDN.jQuery('#filterSummary').append(' <a href="#" class="'+WDN.jQuery(this).attr('value')+'"><span class="group">'+WDN.jQuery(this).closest('fieldset').children('legend').text()+':</span> '+WDN.jQuery(this).siblings('label').text()+'</a>')
					}
				});
				totalDisplayed = WDN.jQuery('dt.course:visible, #majorListing li:visible').length;
				WDN.jQuery('h2.resultCount span').remove();
				WDN.jQuery('h2.resultCount').prepend('<span>'+totalDisplayed+' of </span> ')
				if (one_checked == false) { //no checkboxes are checked, so show all
				    WDN.jQuery('dd.course, dt.course, #majorListing li').show();
				    WDN.jQuery('.filterAll').attr('checked', 'checked');
				    WDN.jQuery('h2.resultCount span').remove();
				}
			}
    	});
	});
    /*
     * 
     * Qtip for course links in content text blocks.
     * 
     */
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
	            		tooltip : 'courseInfo'
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
		delay: 555,
		minLength: 2,
		search: function(event, ui){
			if (keyMatch) {
				WDN.log('invalid key');
				return false;
			}
		},
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
	    					rows[i] = { 
	    						label: '<dt class="course">' +
		    								'<span class="subjectCode">' + data[i].courseCodes[0].subject + '</span>' +
		    								'<span class="number">' + data[i].courseCodes[0].courseNumber + '</span>' +
		   								'<span class="title">' + data[i].title + '</span>' +
		    								'<span class="key" style="display:none;">' + data[i].courseCodes[0].subject + data[i].courseCodes[0].courseNumber + data[i].title + '</span>' +
	    								'</dt>',
	    						value: data[i].courseCodes[0].subject + " " + data[i].courseCodes[0].courseNumber + ": " + data[i].title,
	    						key: data[i].courseCodes[0].subject + data[i].courseCodes[0].courseNumber + data[i].title
	    					};
					    }
				    response(rows);
			    }
    		})
    	},
    	open: function(){
    		$('#courseSearch').qtip("hide");
    	},
    	focus: function(e, ui) {
    		$('a.indicator').removeClass('indicator');
			$('a:contains("'+ui.item.key+'")').addClass('indicator');
		},
		select: function(e, ui) {
			window.location.href = UNL_UGB_URL+'courses/search?q='+ui.item.value;
		}
    });
    $('#courseSearch').keypress(function(event){
    	var e = event.keyCode;
    	keyMatch = false;
    	if(e == 27 || e == 9 || e == 13){
    		keyMatch = true;
    		WDN.log(keyMatch);
    	}
    });
    $('#majorSearch').autocomplete({
    	delay: 555,
		minLength: 3,
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
    //When we have the search combo, run these functions
    if ($('#search_forms').length > 0) {
        if ($('#search_forms').parent('.activate_major').length > 0) { // we have a major search instead, so reset defaults
            $('#search_forms .option').toggleClass('active');
        }
        $('#search_forms form').hide();
        selected = $('#search_forms .option.active').attr('id');
        $('#'+selected+'form').show();
        $('#search_forms .option').click(function(){
            if (!($(this).hasClass('active'))) {
                $('#search_forms .option').toggleClass('active');
                $('#search_forms form').toggle();
            }
        }).keyup(function(event){
            if (event.keyCode == 13){
               $('#search_forms .option').toggleClass('active');
               $('#search_forms form').toggle(); 
            }
        });
    }
    $('.search input[type="text"]').focus(function(){
        $(this).prev('label').hide();
    }).blur(function(){
        if ($(this).val().length == 0){
            $(this).prev('label').show();
        }
    }).each(function() {
        if ($(this).val().length != 0){
            $(this).prev('label').hide();
        }
    });
    $('.search label').click(function(){
        $(this).hide(function(){
            $(this).next('input[type="text"]').focus();
        });
    });
});

function fadeInTOCMenu() {
	if (!menuFaded) { //menu is hidden
		WDN.log('fading menu in');
		WDN.jQuery('#toc_nav').css({'position': 'fixed', 'width': '960px'});
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

function accomodateHash() {
	hashLocation = WDN.jQuery(window.location.hash).offset();
	WDN.jQuery(window).scrollTop(hashLocation.top - 60);
}

/*
 * 
 * For the filter box interactivities.
 * 
 */
