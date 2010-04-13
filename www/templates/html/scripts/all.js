function setTOCLocations() {
	try {
		tocLocation = WDN.jQuery('#toc_nav').offset();
		lcLocation = WDN.jQuery('#long_content').offset();
		WDN.log(tocLocation.top);
	} catch(e) {}
}
WDN.jQuery(document).ready(function($){
	menuFaded = false;
	setTOCLocations();
	WDN.jQuery('#toc_bar').html(WDN.jQuery('#maincontent h1:first').html());
	if (tocLocation) {
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
	}
	if (WDN.jQuery(window).scrollTop() > (tocLocation.top - 10)) {//if the page loads and the top of the window is below the TOC, then show the TOC menu
		fadeInTOCMenu();
		menuFaded = true;
	}
//Deal with the Table of Contents for the majors pages.
	WDN.jQuery("#toc_nav ol").click(
		function() {
			WDN.jQuery("#toc_nav ol").hide();
		}
	);
	WDN.jQuery("#toc_nav").hover(
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
		$('#officialMessage').wrap("<div class='col right wdn_notice_wrapper'></div>");
		$('#officialMessage').children("div.message").children("p").children("a").insertAfter("div.message p").siblings("p").hide();
		$('#officialMessage').children(".minimize").removeClass("minimize").addClass("maximize");
		setTOCLocations();
	};
	
    $(".minimize, .maximize").click(function() {
    	if ($(this).parent('.wdn_notice').parent('.wdn_notice_wrapper').length > 0) { //let's show the full notice
    		$(this).parent(".wdn_notice").slideUp("slow", function() {
    			$(this).unwrap(".wdn_notice_wrapper");
    			$(this).children("div.message").children("a").appendTo("div.message p");
    			$("div.message p").show();
    			$(this).children(".maximize").removeClass("maximize").addClass("minimize");
    			$(this).slideDown("slow", function() {setTOCLocations()});
    		});
    	} else {
    		$(this).parent(".wdn_notice").slideUp("slow", function() { //let's hide the full notice
    			$(this).wrap("<div class='col right wdn_notice_wrapper'></div>"); //wrap in a col, floated right
    			$(this).children("div.message").children("p").children("a").insertAfter("div.message p").siblings("p").hide();
    			$(this).children(".minimize").removeClass("minimize").addClass("maximize");
    			$(this).slideDown("slow", function() {setTOCLocations()});
    			WDN.setCookie('notice', 'y', 3600);
    		});
    	}
    	return false;
    });
    //End: Deal with the interactivity behind the wdn_notice
    
    //$('#maincontent a.course').click(function(eventObject){
    	//$(this).colorbox({width:"640px",href:this.href+'?format=partial',open:true});
    	//eventObject.preventDefault();
    //});
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
			if (WDN.jQuery(this).attr('value') === "all") {
				if (this.checked){
					WDN.jQuery('#filters input').not('#filterAll').removeAttr('checked');
					WDN.jQuery('.course').show();
				} 
			} else {
				WDN.jQuery('#filterAll').removeAttr('checked');
				WDN.jQuery('.course').hide();
				var one_checked = false;
				WDN.jQuery('#filters input').not('#filterAll').each(function(){
					if (this.checked) {
					    one_checked = true;
						WDN.jQuery('.'+WDN.jQuery(this).attr('value')).show();
					}
				});
				if (one_checked == false) {
				    WDN.jQuery('.course').show();
				    WDN.jQuery('#filterAll').attr('checked', 'checked');
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
	            		target : 'topRight',
	            		tooltip : 'bottomLeft'
	            	},
	            	container: $('body'),
	            	adjust : {
	            		screen : true,
	            		y : 3,
	            		x : -10
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
	            		corner: 'bottomLeft' ,
	            		size: { x: 25, y: 25 }
	            	},
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
    
    $('#courseSearch, #majorSearch').attr("autocomplete", "off");
    var searching = false;
    var search_string = '';
    $('#courseSearch').keyup(
            function(){
                if (this.value.length > 2) {
                    if (search_string != this.value) {
                        search_string = this.value;
                        clearTimeout(searching);
                        WDN.jQuery('#courseSearchResults').html('<img src="/wdn/templates_3.0/css/header/images/colorbox/loading.gif" alt="Loading search results" />');
                        searching = setTimeout(function(){fetchCourseSearchResults(search_string);}, 750);
                    }
                } else {
                    WDN.jQuery('#courseSearchResults').html('');
                }
            }
            );
    function fetchCourseSearchResults(q)
    {
        WDN.get(UNL_UGB_URL+'courses/search?q='+escape(q)+'&format=partial', null, function(content){WDN.jQuery('#courseSearchResults').html(content);});
    }
    $('#majorSearch').autocomplete({ 
    	source: function(request, response) {
    		WDN.get(UNL_UGB_URL+'majors/search?q='+escape(request.term)+'&format=partial', null, function(content){
    			WDN.jQuery('#majorSearchResults').html(content);
    			WDN.jQuery('#majorSearchResults h2').remove();
        });
    	}
    });
    /*
    $('#majorSearch').keydown(
            function(event){
            	$('#majorSearchResults').show();
            	currentFocus = $(this).attr('id');
            	if (this.value.length > 2) {
                    if (search_string != this.value) {
                        search_string = this.value;
                        clearTimeout(searching);
                        WDN.jQuery('#majorSearchResults').html('<img src="/wdn/templates_3.0/css/header/images/colorbox/loading.gif" alt="Loading search results" />');
                        searching = setTimeout(function(){fetchMajorSearchResults(search_string);}, 250);
                    }
                } else {
                    WDN.jQuery('#majorSearchResults').html('');
                }
            	if (event.keyCode == '40') { //user has used the down arrow
            		if (currentFocus == 'majorSearch') {
            			$('#majorSearchResults ul li:first').focus();
            			currentFocus = $(this).attr('id');
            			WDN.log(currentFocus);
            		}
            	}
            	if (event.keyCode == '38') { //user has used the up arrow
            		
            	}
            	if (event.keyCode == '27') {//esc key
            		$('#majorSearchResults').hide();
            	}
            }
            );
    $('#majorSearch').focusout(function(){
    	$('#majorSearchResults').hide();
    });
    */
    function fetchMajorSearchResults(q)
    {
        WDN.get(UNL_UGB_URL+'majors/search?q='+escape(q)+'&format=partial', null, function(content){
        	WDN.jQuery('#majorSearchResults').html(content);
        	WDN.jQuery('#majorSearchResults h2').remove();
        });
    }
});

function fadeInTOCMenu() {
	if (!menuFaded) { //menu is hidden
		WDN.log('fading menu in');
		WDN.jQuery('#toc_nav').css({'position': 'fixed'});
		WDN.jQuery('#long_content').css({'margin-top':'73px'});	
		WDN.jQuery('#toc_bar').fadeIn(200);
	}
} 
function fadeOutTOCMenu() {
	if (menuFaded) { //menu is displayed
		WDN.log('fading menu out');
		WDN.jQuery('#toc_nav').css({'position': 'relative'});
		WDN.jQuery('#toc_bar').fadeOut(200);
		WDN.jQuery('#long_content').css({'margin-top':'35px'});
	}
} 
