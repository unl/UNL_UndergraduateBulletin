function accomodateHash() {
    hashLocation = $(window.location.hash).offset();
    $(window).scrollTop(hashLocation.top - 60);
}

WDN.initializePlugin('jqueryui', [function () {
	var $ = require('jquery');
    var testCount = 0;
    
    // Append Versioning to the top
    $('#pagetitle h1').append( $('#versioning').animate({ opacity: 1 }, 500 ) );

    //Show/Hide the course information
    $('#toggleAllCourseDescriptions').click(function() {
        $('dd').slideToggle();
        $('#maincontent .title a').toggleClass('showIt');
        return false;
    });
    $('h2.resultCount').after('<p id="filterSummary">Displaying: <a href="#" class="all">All Options</a></p>');
    $('form.filters input').each(function(){
        if ($(this).attr('value') !== "all") {
            // Check and see if we actually have any of these courses
            var total = $('.'+$(this).attr('value')).length; //count all based on class
            if (total === 0) {
                $(this).attr('disabled', 'disabled'); //disable the input/label
                $(this).closest('li').addClass('disabled');
                return true;
            } else {
                if ($(this).closest('form').hasClass('courseFilters')) { //otherwise calculate the count
                    total = total/2;
                }
                if ( $(this).next('label').children('.count').length == 0 ) { // if span.count doesn't already exists
                    $('label[for='+this.id+']').append(' <span class="count">('+total+')</span>'); // add the count
                }

            }
        }
        $(this).click(function() {
            if ($(this).hasClass('filterAll')) { //if all was checked, then put the checkmark next to all alls, and show everything.
                if (this.checked){
                    $('form.filters input').not('.filterAll').removeAttr('checked');
                    $('.filterAll').attr('checked', 'checked');
                    $('dd.course, dt.course, #majorListing li').show();
                    $('#filterSummary a').remove();
                    $('#filterSummary').append('<a href="#" class="all">All Options</a>');
                    $('h2.resultCount span').remove();
                }
            } else {
                $('.filterAll').removeAttr('checked'); //uncheck the all checkboxes
                $('dd.course, dt.course, #majorListing li').hide(); //hide all the coures and majors
                var one_checked = false;
                $('#filterSummary a').remove();
                $('form.filters input').not('.filterAll').each(function(){ //loop through all the checkboxes
                    if (this.checked) {
                        one_checked = true;
                        $('li.'+$(this).attr('value')+', dd.'+$(this).attr('value')+', dt.'+$(this).attr('value')).show(); //if a checkbox is checked, make sure the corresponding content is shown.
                        $('#filterSummary a.all').remove();
                        //$('#filterSummary').append(' <a href="#" class="'+$(this).attr('value')+'"><span class="group">'+$(this).closest('fieldset').children('legend').text()+':</span> '+$(this).siblings('label')[0].childNodes[0].nodeValue+'</a>')
                        $('#filterSummary').append('<a href="#" class="'+$(this).attr('value')+'"><span class="group">'+$(this).closest('fieldset').children('legend').text()+':</span> '+$(this).siblings('label').text()+'</a>');
                    }
                });
                totalDisplayed = $('dt.course:visible, #majorListing li:visible').length;
                $('h2.resultCount span').remove();
                $('h2.resultCount').prepend('<span>'+totalDisplayed+' of </span> ');
                if (one_checked === false) { //no checkboxes are checked, so show all
                    $('dd.course, dt.course, #majorListing li').show();
                    $('.filterAll').attr('checked', 'checked');
                    $('h2.resultCount span').remove();
                }
            }
        });
    });

    //Deal with the Versioning controls
    function setSessionCookie(name, value) {
        var path = '/';
        document.cookie = name + "=" + value + ";path=" + path;
    }

    // Disable linking for dropdown
    if ( Modernizr.mq('only all and (max-width: 768px)')) {
        $('#versioning .selected a').click(function(e) { 
            var dropdown = $(this).parents('#versioning ul');

            if (!dropdown.is('.open')) {
                e.preventDefault();
                $("#versioning ul").addClass("open");
            }

            // Touch close icon or touch outside of box to close
            $(document).on('click touchstart', function (e) {
                var container = $("#versioning ul"),
                closeBtn = $('#versioning .close span');

                if ( ( closeBtn.is(e.target) )                  // If you click the close button
                    || (!container.is(e.target)                 // if the target of the click isn't the container...
                    && container.has(e.target).length == 0) )   // ... nor a descendant of the container
                {
                    container.removeClass("open");
                }
            });
        });
    }

    // Course and Major Search Bar
    WDN.jQuery('#courseSearch, #majorSearch').attr("autocomplete", "off");

    $('#courseSearch').on({
        focus: function() {
            $("#courseform .search_help").addClass( "open" );
        }, blur: function() {
        	if ($(document.activeElement).attr('href') !== undefined) {
        		// User is clicking a link, prevent hide of the help text
    			$("#courseform .search_help").removeClass( "open" );
        	}
        }, keyup: function() {
        	setTimeout(function() {$("#courseform .search_help").removeClass( "open" );}, 100);
        }
    });

    if ($('#courseSearch').length > 0){
        WDN.jQuery('#courseSearch').autocomplete({
            delay: 555,
            minLength: 2,
            search: function(event, ui){
                if (keyMatch) {
                    WDN.log('invalid key');
                    return false;
                }
            },
            source: function(request, response) {
                WDN.jQuery.ajax({
                    url: UNL_UGB_URL+'courses/search?q='+request.term+'&format=json&limit=10',
                    dataType: "json",
                    success: function(data) {
                        var rows = [];
                            for(var i=0; i<data.length; i++){
                                //label is for the suggestion
                                //value is for the input box
                                //key is used to match highlighted course
                                rows[i] = {
                                    label: '<dt class="course">' +
                                                '<div class="courseID">' +
                                                    '<span class="subjectCode">' + data[i].courseCodes[0].subject + '</span>' +
                                                    '<span class="number">' + data[i].courseCodes[0].courseNumber + '</span>' +
                                                '</div>' +
                                                '<span class="title">' + data[i].title + '</span>' +
                                                '<span class="key" style="display:none;">' + data[i].courseCodes[0].subject + data[i].courseCodes[0].courseNumber + data[i].title + '</span>' +
                                            '</dt>',
                                    value: data[i].courseCodes[0].subject + " " + data[i].courseCodes[0].courseNumber + ": " + data[i].title,
                                    key: data[i].courseCodes[0].subject + data[i].courseCodes[0].courseNumber + data[i].title
                                };
                            }
                        response(rows);
                    }
                });
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
        }).data( "uiAutocomplete" )._renderItem = function( ul, item ) {
            return WDN.jQuery( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.label + "</a>" )
                .appendTo( ul );
        };
        WDN.jQuery('#courseSearch').keypress(function(event){
            var e = event.keyCode;
            keyMatch = false;
            if(e == 27 || e == 9 || e == 13){
                keyMatch = true;
                WDN.log(keyMatch);
            }
        });
    }
    if ($('#majorSearch').length > 0) {
        WDN.jQuery('#majorSearch').autocomplete({
            delay: 555,
            minLength: 3,
            source: function(request, response) {
                WDN.jQuery.ajax({
                    url: UNL_UGB_URL+'major/search?q='+request.term+'&format=json',
                    dataType: "json",
                    success: function(data) {
                        var rows = [];
                            for(var i=0; i<data.length; i++){
                                rows[i] = {
                                        label : '<span class="format">'+data[i]['title']+'</span>' +
                                                '<span class="key" style="display:none;">'+data[i]['title']+i+'</span>',
                                        value : data[i]['title'],
                                        key : data[i]['title']+i
                                };
                            }
                        response(rows);
                    }
                });
            },
            focus: function(e, ui) {
                $('a.indicator').removeClass('indicator');
                $('a:contains("'+ui.item.key+'")').addClass('indicator');
            },
            select: function(e, ui) {
                window.location.href = UNL_UGB_URL+'major/'+ui.item.value;
            }
        }).data( "uiAutocomplete" )._renderItem = function( ul, item ) {
            return WDN.jQuery( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.label + "</a>" )
                .appendTo( ul );
        };
    }

    //Deal with the Table of Contents for the majors pages.
    $('#tocToggle').on('click touchstart', function (e) {
        e.preventDefault();
        $(this).toggleClass('close');
        $('#toc').toggleClass('open');
    });

    WDN.loadJS(UNL_UGB_BASEURL + 'templates/html/scripts/jQuery.toc.js', function() {
    	var $ = WDN.jQuery;
	    $("#toc").tableOfContents(
	            $("#long_content"),      // Scoped to div#long_content
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
    });

    /*
     * 
     * Qtip for course links in content text blocks.
     * 
     */
    $("#maincontent a.course").each(function () {
        try {
            $(this).qtip({
                content : {
                    text: 'Loading...',
                    ajax : {
                        url: this.href+'?format=partial',
                        method: 'GET',
                        data: {}
                    }
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
                }
            });
            /*
            $(this).qtip("api").beforeShow = function(){
                // Check the content
                if ($('div[qtip='+this.id+'] div.qtip-content dt').length == 0) {
                    $('div[qtip='+this.id+']').css({width:'120px'});
                    $('div[qtip='+this.id+'] div.qtip-content').html('<p>Could not find that course.</p>');
                }
                return true;
            };
            */
        } catch(e) {}
    });

    //When we have the search combo, run these functions
    var $search_forms = $('#search_forms');
    
    if ($search_forms.length > 0) {
        if ($search_forms.parent('.activate_major').length > 0) { // we have a major search instead, so reset defaults
        	$search_forms.find('.option').toggleClass('active');
        }
        $search_forms.find('form').hide();
        selected = $search_forms.find('.option.active').attr('id');
        $('#'+selected+'form').show();
        $search_forms.find('.option').click(function(){
            if (!($(this).hasClass('active'))) {
            	$search_forms.find('.option').toggleClass('active');
            	$search_forms.find('form').toggle();
            }
        }).keyup(function(event){
            if (event.keyCode == 13){
            	$search_forms.find('.option').toggleClass('active');
            	$search_forms.find('form').toggle();
            }
        });
    }

}]);