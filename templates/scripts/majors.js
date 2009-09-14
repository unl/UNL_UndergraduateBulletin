wraphandler.addEvent(window,"load", function() {
	//Deal with the Table of Contents for the majors pages.
	WDN.jQuery("#major_nav ol").click(
		function() {
			WDN.jQuery("#major_nav ol").hide();
		}
	);
    WDN.jQuery("#major_nav").hover(
		function() {
	        WDN.jQuery("#major_nav ol").show();
	    },
	    function() {
	        WDN.jQuery("#major_nav ol").hide();
	    }
    );
    WDN.jQuery("#major_nav ol").hide();
    WDN.jQuery("#toc").tableOfContents(
    		WDN.jQuery("#long_content"),      // Scoped to div#long_content
      {
        startLevel: 2,    // H1 and up
        depth:      2,    // H1 through H4,
        topLinks:   false, // Add "Top" Links to Each Header
      }
    );
    //End Deal with the Table of Contents for the majors pages.
    //
    //Deal with the interactivity behind the wdn_notice
    WDN.jQuery(".minimize").click(function() {
    	WDN.jQuery(this).parent(".wdn_notice").slideUp("slow", function() {
    			WDN.jQuery(this).wrap("<div class='col right'></div>"); //wrap in a col, floated right
    			WDN.jQuery(this).children("div.message").children("p").children("a").insertAfter("div.message p").siblings("p").hide();
    			WDN.jQuery(this).children(".minimize").removeClass("minimize").addClass("maximize");
    			WDN.jQuery(this).slideDown("slow");
    	});
    });
    
});