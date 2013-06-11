function setTOCLocations() {
    try {
        tocLocation = $('#toc_nav').offset();
        lcLocation = $('#long_content').offset();
        //WDN.log(tocLocation.top);
    } catch(e) {}
}

function fadeInTOCMenu() {
    if (!menuFaded) { //menu is hidden
        WDN.log('fading menu in');
        $('#toc_nav').css({'position': 'fixed', 'width': '960px'});
        $('#toc_major_name').css({'display': 'block'});
        $('#long_content').css({'margin-top':'73px'});
        $('#toc_bar').fadeIn(200);
    }
}
function fadeOutTOCMenu() {
    if (menuFaded) { //menu is displayed
        WDN.log('fading menu out');
        $('#toc_nav').css({'position': 'relative', 'width': 'auto'});
        $('#toc_major_name').css({'display': 'none'});
        $('#toc_bar').fadeOut(200);
        $('#long_content').css({'margin-top':'35px'});
    }
}

function accomodateHash() {
    hashLocation = $(window.location.hash).offset();
    $(window).scrollTop(hashLocation.top - 60);
}

$(document).ready(function() {
    var c = WDN.getCookie('notice');

    //Move the subhead above the notice
    $('.subhead').insertBefore('#officialMessage');

    //Deal with the interactivity behind the wdn_notice
    if (c) {
        $('#officialMessage').addClass('small');
        $('#officialMessage .minimize').removeClass('minimize').addClass('maximize');
        $("#officialMessage div.message p, #previousBulletins").hide();
        $("#bulletinRules").insertAfter("#officialMessage div.message h4").css({'margin-left' : '10px', 'font-size' : '0.8em'});
        setTOCLocations();
    }

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
                    setTOCLocations();
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
                    setTOCLocations();
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
                $('label[for='+this.id+']').append(' <span class="count">('+total+')</span>'); // add the count
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

    $('#versioning .action').click(function(){
        if ($(this).hasClass('opened')) {
            setSessionCookie("va", "closed");
        } else {
            setSessionCookie("va", "opened");
        }
        // slide is a jQuery UI effect
        WDN.loadJQuery(function() {
            WDN.jQuery('#versioning .content').toggle('slide', {percent : 0, direction : 'right'}, 500, function(){
                WDN.jQuery('#versioning .action').toggleClass('opened');
            });
        });
        return false;
    });
    var va = WDN.getCookie('va');
    if(va === 'closed'){
        $('#versioning .action').click();
    }

    WDN.jQuery('#courseSearch, #majorSearch').attr("autocomplete", "off");

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
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
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
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return WDN.jQuery( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.label + "</a>" )
                .appendTo( ul );
        };
    }

    //Deal with the Table of Contents for the majors pages.
    $("#toc_nav ol").click(
        function() {
            $("#toc_nav ol").hide();
        }
    );
    $("#tocContent, #toc").hover(
        function() {
            $("#toc_nav ol").show();
            $("#toc_nav ol a").click(function(event) {
                //we need to go to the #ID, but above it by 60 pixels
                var headingTarget = $($(this).attr('href')).offset();
                $(window).scrollTop(headingTarget.top - 60);
                fadeInTOCMenu();
                menuFaded = true;
                event.preventDefault();
                window.location.hash = $(this).attr('href');
                accomodateHash();
            });
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
        topLinks:   false, // Add "Top" Links to Each Header
        callback : function() {
                if (window.location.hash) {
                    accomodateHash();
                }
            }
      }
    );
    menuFaded = false;
    if ($('#toc_nav').length > 0) {
        WDN.log('setting TOC');
        setTOCLocations();

        $(window).scroll(function(){
            if ($(window).scrollTop() > (tocLocation.top - 10)) {//when we scroll to the top of the TOC (+padding) then start scrolling the cotents boc
                fadeInTOCMenu();
                menuFaded = true;
            }
            if($(window).scrollTop() < (lcLocation.top - 73)) {
                fadeOutTOCMenu();
                menuFaded = false;
            }
        });

        if ($(window).scrollTop() > (tocLocation.top - 10)) {//if the page loads and the top of the window is below the TOC, then show the TOC menu
            fadeInTOCMenu();
            menuFaded = true;
        }
        //deal with small window heights and large toc height
        WDN.log ($('#toc').height());
        WDN.log (($(window).height() * 0.85));
        if ($('#toc').height() > ($(window).height() * 0.85)) {
            $('#toc').css({'max-height' : $(window).height() * 0.85, 'overflow-y' : 'scroll', '-ms-overflow-y' : 'scroll'});
        }
    }
    //End: Deal with the Table of Contents for the majors pages.

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
        if ($(this).val().length === 0){
            $(this).prev('label').show();
        }
    }).each(function() {
        if ($(this).val().length !== 0){
            $(this).prev('label').hide();
        }
    });
    $('.search label').click(function(){
        $(this).hide(function(){
            $(this).next('input[type="text"]').focus();
        });
    });
});