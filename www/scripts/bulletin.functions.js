define([
    'jquery',
    'wdn',
    'modernizr',
    'notice',
    './jQuery.toc.js'
], function($, WDN, Modernizr) {
    return function(baseUrl) {
        var testCount = 0;
        var tableOfContentsSelector = '#toc';
        var versioningSelector = '#versioning';
        var $versioning = $('#versioning');
        var openClass = 'open';
        var closeClass ='close';
        var courseSearchSelector = '#courseSearch';
        var majorSearchSelector = '#majorSearch';
        var $courseSearch = $(courseSearchSelector);
        var $majorSearch = $(majorSearchSelector);
        var indicatorClass = 'indicator';
        var activeClass ='active';

        // Append Versioning to the top
        $('#pagetitle h1').append( $versioning.animate({ opacity: 1 }, 500 ) );

        //Deal with the Table of Contents for the majors pages.
        $('#tocToggle').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass(closeClass);
            $(tableOfContents).toggleClass(openClass);
        });

        $(tableOfContentsSelector).tableOfContents(
            $("#long_content"), // Scoped to div#long_content
            {
                startLevel: 2, // H1 and up
                depth: 2, // H1 through H4,
                topLinks: false, // Add "Top" Links to Each Header
                callback : function() {
                    if (window.location.hash) {
                        var hashLocation = $(window.location.hash).offset();
                        // [HACK] To get all browsers to jump to the proper load location
                        setTimeout(function() {
                            $(window).scrollTop(hashLocation.top - 60);
                        }, 100);
                    }
                }
            }
        );

        // Disable linking for dropdown
        if (Modernizr.mq('only all and (max-width: 768px)')) {
            $('.selected a', $versioning).click(function(e) {
                var dropdown = $(this).closest('ul');

                if (!dropdown.hasClass(openClass)) {
                    e.preventDefault();
                    $dropdown.addClass(openClass);
                }
            });

            // Touch close icon or touch outside of box to close
            $(document).on('click', function (e) {
                var container = $('ul', $versioning),
                closeBtn = $('.close span', $versioning);

                if (closeBtn.is(e.target) || !container.find(e.target).length) {
                    container.removeClass(openClass);
                }
            });
        }

        //When we have the search combo, run these functions
        var $search_forms = $('#search_forms');

        if ($search_forms.length) {
            if ($search_forms.parent('.activate_major').length) { // we have a major search instead, so reset defaults
                $search_forms.find('.option').toggleClass(activeClass);
            }

            $search_forms.find('form').hide();
            selected = $search_forms.find('.option.active').attr('id');

            if (selected === 'major') {
                $('#majorform').show();
            } else {
                $('#courseform').show();
            }

            $search_forms.find('.option').click(function(){
                if (!($(this).hasClass('active'))) {
                    $search_forms.find('.option').toggleClass(activeClass);
                    $search_forms.find('form').toggle();
                }
            }).keyup(function(event){
                if (event.keyCode == 13){
                    $search_forms.find('.option').toggleClass(activeClass);
                    $search_forms.find('form').toggle();
                }
            });
        }

        // filters
        $('h2.resultCount').after('<p id="filterSummary">Displaying: <a href="#" class="all">All Options</a></p>');
        $('form.filters input').each(function(){
            if ($(this).attr('value') !== "all") {
                // Check and see if we actually have any of these courses
                var total = $('.'+$(this).attr('value')).length; //count all based on class
                if (!total) {
                    $(this).attr('disabled', 'disabled'); //disable the input/label
                    $(this).closest('li').addClass('disabled');
                    return true;
                } else {
                    if ($(this).closest('form').hasClass('courseFilters')) { //otherwise calculate the count
                        total = total;
                    }
                    if (!$(this).next('label').children('.count').length) { // if span.count doesn't already exists
                        $('label[for='+this.id+']').append(' <span class="count">('+total+')</span>'); // add the count
                    }

                }
            }
            $(this).click(function() {
                if ($(this).hasClass('filterAll')) { //if all was checked, then put the checkmark next to all alls, and show everything.
                    if (this.checked){
                        $('form.filters input').not('.filterAll').removeAttr('checked');
                        $('.filterAll').attr('checked', 'checked');
                        $('div.course, #majorListing li').show();
                        $('#filterSummary a').remove();
                        $('#filterSummary').append('<a href="#" class="all">All Options</a>');
                        $('h2.resultCount span').remove();
                    }
                } else {
                    $('.filterAll').removeAttr('checked'); //uncheck the all checkboxes
                    $('div.course, #majorListing li').hide(); //hide all the coures and majors
                    var one_checked = false;
                    $('#filterSummary a').remove();
                    $('form.filters input').not('.filterAll').each(function(){ //loop through all the checkboxes
                        if (this.checked) {
                            one_checked = true;
                            $('li.'+$(this).attr('value')+', div.'+$(this).attr('value')).show(); //if a checkbox is checked, make sure the corresponding content is shown.
                            $('#filterSummary a.all').remove();
                            //$('#filterSummary').append(' <a href="#" class="'+$(this).attr('value')+'"><span class="group">'+$(this).closest('fieldset').children('legend').text()+':</span> '+$(this).siblings('label')[0].childNodes[0].nodeValue+'</a>')
                            $('#filterSummary').append('<a href="#" class="'+$(this).attr('value')+'"><span class="group">'+$(this).closest('fieldset').children('legend').text()+':</span> '+$(this).siblings('label').text()+'</a>');
                        }
                    });
                    totalDisplayed = $('div.course:visible, #majorListing li:visible').length;
                    $('h2.resultCount span').remove();
                    $('h2.resultCount').prepend('<span>'+totalDisplayed+' of </span> ');
                    if (one_checked === false) { //no checkboxes are checked, so show all
                        $('div.course, #majorListing li').show();
                        $('.filterAll').attr('checked', 'checked');
                        $('h2.resultCount span').remove();
                    }
                }
            });
        });

        WDN.initializePlugin('jqueryui', [function () {
            if ($courseSearch.length) {
                var $courseFormHelp = $('#courseform .search_help');

                $courseSearch.on({
                    focus: function() {
                        $courseFormHelp.addClass(openClass);
                    },
                    blur: function() {
                        if ($(document.activeElement).attr('href') !== undefined) {
                            // User is clicking a link, prevent hide of the help text
                            $courseFormHelp.removeClass(openClass);
                        }
                    },
                    keyup: function() {
                        setTimeout(function() {
                            $courseFormHelp.removeClass(openClass);
                        }, 100);
                    }
                });

                $courseSearch.attr('autocomplete', 'off');

                $courseSearch.autocomplete({
                    delay: 555,
                    minLength: 2,
                    source: function(request, response) {
                        $.ajax({
                            url: baseUrl+'courses/search?q='+request.term+'&format=json&limit=10',
                            dataType: "json",
                            success: function(data) {
                                var rows = [];
                                    for(var i=0; i<data.length; i++){
                                        //label is for the suggestion
                                        //value is for the input box
                                        //key is used to match highlighted course
                                        rows[i] = {
                                            label: '<div class="course">' +
                                                        '<div class="courseID">' +
                                                            '<span class="subjectCode">' + data[i].courseCodes[0].subject + '</span>' +
                                                            '<span class="number">' + data[i].courseCodes[0].courseNumber + '</span>' +
                                                        '</div>' +
                                                        '<span class="title">' + data[i].title + '</span>' +
                                                        '<span class="key" style="display:none;">' + data[i].courseCodes[0].subject + data[i].courseCodes[0].courseNumber + data[i].title + '</span>' +
                                                    '</div>',
                                            value: data[i].courseCodes[0].subject + " " + data[i].courseCodes[0].courseNumber + ": " + data[i].title,
                                            key: data[i].courseCodes[0].subject + data[i].courseCodes[0].courseNumber + data[i].title
                                        };
                                    }
                                response(rows);
                            }
                        });
                    },
                    focus: function(e, ui) {
                        $('a.indicator').removeClass(indicatorClass);
                        $('a:contains("'+ui.item.key+'")').addClass(indicatorClass);
                    },
                    select: function(e, ui) {
                        window.location.href = baseUrl+'courses/search?q='+ui.item.value;
                    }
                }).autocomplete('instance')._renderItem = function( ul, item ) {
                    return $('<li>')
                        .data( "item.autocomplete", item )
                        .append( "<a>"+ item.label + "</a>" )
                        .appendTo( ul );
                };
            }


            if ($majorSearch.length) {
                $majorSearch.attr('autocomplete', 'off');

                $majorSearch.autocomplete({
                    delay: 555,
                    minLength: 3,
                    source: function(request, response) {
                        $.ajax({
                            url: baseUrl+'major/search?q='+request.term+'&format=json',
                            dataType: "json",
                            success: function(data) {
                                var rows = [];
                                    for(var i=0; i<data.length; i++){
                                        rows[i] = {
                                                label : '<span class="format">'+data[i].title+'</span>' +
                                                        '<span class="key" style="display:none;">'+data[i].title+i+'</span>',
                                                value : data[i].title,
                                                key : data[i].title+i
                                        };
                                    }
                                response(rows);
                            }
                        });
                    },
                    focus: function(e, ui) {
                        $('a.indicator').removeClass(indicatorClass);
                        $('a:contains("'+ui.item.key+'")').addClass(indicatorClass);
                    },
                    select: function(e, ui) {
                        window.location.href = baseUrl+'major/'+ui.item.value;
                    }
                }).autocomplete('instance')._renderItem = function( ul, item ) {
                    return $('<li>')
                        .data( "item.autocomplete", item )
                        .append( "<a>"+ item.label + "</a>" )
                        .appendTo( ul );
                };
            }
        }]);
    };
});
