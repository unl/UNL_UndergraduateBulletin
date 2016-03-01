define([
    'jquery',
    'wdn',
    'modernizr',
    'require',
    'notice',
    './jQuery.toc.js'
], function($, WDN, Modernizr, require) {
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
        var activeClass ='active';
        var textExpand = '(Expand)';
        var textCollapse = '(Collapse)';

        // Append Versioning to the top
        $('#pagetitle h1').append( $versioning.animate({ opacity: 1 }, 500 ) );

        //Deal with the Table of Contents for the majors pages.
        $('#tocToggle').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass(closeClass);
            $(tableOfContentsSelector).toggleClass(openClass);
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

        Filters = function($filters) {
            var controls = $('.filters', $filters).attr('aria-controls');
            this.filters = $filters;
            this.results = $('#' + controls);
            var $summary = $('.summary', this.results);
            var $options = $('.filter-options', this.filters);
            var $toggles = $('.toggle', this.filters);
            var optionAnimation = 'slideDown';
            var optionAriaExpanded = 'true';
            var optionToggleText = '(Collapse)';
            this.resultsSelector = '.majorlisting li, div.course';

            if ($(window).width() < 768) {
                optionAnimation = 'slideUp';
                optionAriaExpanded = 'false';
                optionToggleText = '(Expand)';
            }

            $options[optionAnimation](100);
            $options.attr('aria-expanded', optionAriaExpanded);
            $toggles.text(optionToggleText);

            if (!$summary.length) {
                $summary = $(this.generateSummaryTemplate())
                    .append(this.generateAllSummaryOption())
                    .prependTo(this.results);
            }

            var $allResults = $(this.resultsSelector, this.results);

            $('input', $options).not('.filterAll').each(function() {
                // Check and see if we actually have any of these courses
                var total = $allResults.filter('.' + $(this).attr('value')).length; //count all based on class
                var $label = $(this).next('label');

                if (!total) {
                    $(this).prop('disabled', true); //disable the input/label
                    $(this).closest('li').addClass('disabled');
                    return true;
                } else {
                    if (!$label.children('.count').length) { // if span.count doesn't already exists
                        $label.append(' <span class="count">('+total+')</span>'); // add the count
                    }
                }
            });

            var self = this;

            $filters.on('click', 'button', function (e) {
                var $header = $(this);
                var $container = $header.next();
                var $toggle = $('.toggle', $header);

                $container.slideToggle(100, function () {
                    if ($container.is(':visible')) {
                        //Expanded
                        $toggle.text('(Collapse)');
                        $container.attr('aria-expanded', 'true');
                        $container.focus();
                    } else {
                        //Collapsed
                        $toggle.text('(Expand)');
                        $container.attr('aria-expanded', 'false');
                    }
                });
            });

            $filters.on('click', 'input', function(e) {
                self.action($(this));
            });

            $('input:checked', $filters).each(function() {
                self.action($(this));
            });
        };

        Filters.prototype = {
            generateSummaryTemplate: function() {
                return '<p class="summary" area-live="polite">Displaying: </p>';
            },

            generateAllSummaryOption: function() {
                return '<span class="all selected-options"> All Options</span>';
            },

            generateSummaryOption: function(value, type, label) {
                return [
                    '<span class="',
                    value,
                    ' selected-options"><span class="group">',
                    type,
                    '</span> ',
                    label,
                    '</span> <span class="operator">OR </span>'
                ].join('');
            },

            action : function(checkbox) {
                var checked = [];
                var filterElement = 'input';
                var stateProperty = 'checked';
                var activeFilterSelector = filterElement + ':' + stateProperty;
                var allFilterClass = 'filterAll';
                var allFilterSelector = '.' + allFilterClass;
                var $optionGroup = checkbox.closest('.filter-options');
                var filterState = checkbox[0].checked;
                var self = this;

                var showState = function() {
                    var $checkedFilters = $(activeFilterSelector, self.filters).not(allFilterSelector);
                    var $allResults = $(self.resultsSelector, self.results);

                    if (!$checkedFilters.length) {
                        // return to show everything
                        $allResults.show();
                        return;
                    }

                    // selectively show records
                    $allResults.hide();
                    $checkedFilters.each(function(){
                        var value = $(this).attr('value');
                        var id = $(this).attr('id');

                        if (this.checked) {
                            // make sure the corresponding content is shown.
                            $allResults.filter('.' + value).show();
                            checked.push(id);
                        }
                    });
                };

                var showAll = function(full) {
                    var $scope = $optionGroup;
                    if (full) {
                        $scope = self.filters;
                    }
                    $(filterElement, $scope).not(allFilterSelector).prop(stateProperty, false);
                    $(allFilterSelector, $scope).prop(stateProperty, true);
                    showState();
                };

                if ((checkbox.hasClass(allFilterClass) && filterState) || !$(activeFilterSelector, $optionGroup).length) {
                    showAll();
                } else {
                    $(allFilterSelector, $optionGroup).prop(stateProperty, false);
                    showState();
                }

                var $summary = $('.summary', this.results);
                $('.selected-options, .operator', $summary).remove();

                if (checked.length < 1) {
                    //nothing in the array, therefore it's ALL
                    showAll(true);
                    $summary.append(this.generateAllSummaryOption());
                } else {
                    //at least one id exists in the array
                    var summaryOptions = [];
                    $.each(checked, function(key, value) {
                        var $selected = $('#' + value);

                        if (!$selected.length) {
                            return;
                        }

                        var $legend = $selected.closest('.filter-options').prev('button');

                        summaryOptions.push(document.createTextNode(' '));
                        summaryOptions.push(self.generateSummaryOption($selected.attr('value'), $legend.clone().children().remove().end().text(), $selected.siblings('label').text()));
                        summaryOptions.push(document.createTextNode(' '));
                    });

                    $summary.append(summaryOptions);
                    $('.operator:last-child', $summary).remove();
                }
            }
        };

        // filters
        $('.filters-wrapper').each(function() {
            var $filters = $(this);
            new Filters($filters);
            var $sidebar = $filters.parent();

            require(['./vendor/jquery.sticky-kit.js'], function() {
                var checkSticky = function() {
                    $(document.body).trigger('sticky_kit:recalc');

                    if (Modernizr.mq('only screen and (min-width: 768px)')) {
                        $sidebar.stick_in_parent({spacer:false});
                    } else {
                        $sidebar.trigger('sticky_kit:detach');
                    }
                };
                $(window).on('resize', checkSticky);
                checkSticky();
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
                                var courseCode, i;
                                var rows = [];
                                    for (i = 0; i<data.length; i++) {
                                        //label is for the suggestion
                                        //value is for the input box
                                        //key is used to match highlighted course
                                        courseCode = data[i].courseCodes[0];
                                        rows[i] = {
                                            label: '<div class="course">' +
                                                        '<div class="courseID">' +
                                                            '<span class="subjectCode">' + courseCode.subject + '</span>' +
                                                            '<span class="number">' + courseCode.courseNumber + '</span>' +
                                                        '</div>' +
                                                        '<span class="title">' + data[i].title + '</span>' +
                                                    '</div>',
                                            value: courseCode.subject + " " + courseCode.courseNumber + ": " + data[i].title,
                                            key: courseCode.subject + courseCode.courseNumber + data[i].title,
                                            courseCode: courseCode
                                        };
                                    }
                                response(rows);
                            }
                        });
                    },
                    select: function(e, ui) {
                        window.location.href = baseUrl + 'courses/' + ui.item.courseCode.subject + '/' + ui.item.courseCode.courseNumber;
                    }
                }).autocomplete('instance')._renderItem = function( ul, item ) {
                    return $('<li>')
                        .data( "item.autocomplete", item )
                        .append( item.label )
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
                                                label : '<span class="format">'+data[i].title+'</span>',
                                                value : data[i].title,
                                                key : data[i].title+i
                                        };
                                    }
                                response(rows);
                            }
                        });
                    },
                    select: function(e, ui) {
                        window.location.href = baseUrl+'major/'+ui.item.value;
                    }
                }).autocomplete('instance')._renderItem = function( ul, item ) {
                    return $('<li>')
                        .data( "item.autocomplete", item )
                        .append( item.label )
                        .appendTo( ul );
                };
            }
        }]);
    };
});
