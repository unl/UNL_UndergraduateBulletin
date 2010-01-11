wraphandler.addEvent(window,"load", function() {

    //Deal with the course call numbers that are long
    WDN.jQuery('.number').each(function(){
    	if(WDN.jQuery(this).text().length > 3) {
    		WDN.jQuery(this).addClass('wide');
    	}
    });
    
    // Configure course filters.
    WDN.jQuery('#filters input').click(function(){
    	if (this.checked) {
    		WDN.jQuery('.'+this.value).show();
    	} else {
    		WDN.jQuery('.'+this.value).hide();
    	}
    });
    
});