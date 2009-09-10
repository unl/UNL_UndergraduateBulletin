
wraphandler.addEvent(window,"load", function() {
    WDN.jQuery("#major_nav").hover(function() {
        WDN.jQuery("#major_nav ol").show();
    },
    function() {
        WDN.jQuery("#major_nav ol").hide();
    });
    WDN.jQuery("#major_nav ol").hide();
    WDN.jQuery("#toc").tableOfContents(
    		WDN.jQuery("#long_content"),      // Scoped to div#long_content
      {
        startLevel: 1,    // H1 and up
        depth:      5,    // H1 through H6,
        topLinks:   false, // Add "Top" Links to Each Header
      }
    );
    
});