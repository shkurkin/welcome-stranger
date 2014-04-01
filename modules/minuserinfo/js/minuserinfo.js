/**
 * Created by nathanielhillen on 2/3/14.
 */
$(document).ready(function() {
    $('#stickyWrapper').affix({
        offset: {
            top: 100
        }
    })
});

//Shamelessly borrowed from http://www.jacklmoore.com/notes/jquery-tabs/
$(document).ready(function() {
    var tabs = $('ul.descriptorTags');
    if (tabs.length !== 0) {

        tabs.each(function() {
            // For each set of tabs, we want to keep track of
            // which tab is active and it's associated content
            var $active, $content, $links = $(this).find('a');

            // If the location.hash matches one of the links, use that as the active tab.
            // If no match is found, use the first link as the initial active tab.
            $active = $($links.filter('[href="' + location.hash + '"]')[0] || $links[0]);
            $active.addClass('active');
            $content = $($active.attr('href'));

            // Hide the remaining content
            $links.not($active).each(function() {
                $($(this).attr('href')).hide();
            });

            // Bind the click event handler
            $(this).on('click', 'a', function(e) {
                // Make the old tab inactive.
                $active.removeClass('active');
                $content.hide();

                // Update the variables with the new link and content
                $active = $(this);
                $content = $($(this).attr('href'));

                // Make the tab active.
                $active.addClass('active');
                $content.show();

                // Prevent the anchor's default click action
                e.preventDefault();
            });
        });
    }
});

function expandSearch(){
    var findBar = $("#min_search_query_top");
    var navWidth = $('#stickyinfo').width();
    console.log($(findBar).is(":visible"));
    if($(findBar).width() > 0){
        return;
    } else {
        findBar.show();
        findBar.animate({ width: navWidth, opacity: 1 }, 'fast');
        findBar.blur(function(){
        /* lookup the original width */
        $(this).animate({ width: -1, opacity: 0 }, 'fast');
        });
        findBar.focus();
    }
}
        

