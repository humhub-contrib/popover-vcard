/*
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

var vCardDelayTimer;


$(document).on('mouseenter', '[data-contentcontainer-id]', function () {
    var trigger = this;
    var contentContainerId = $(trigger).data('contentcontainer-id');
    var divId = 'vCard' + contentContainerId;
    clearTimeout(vCardDelayTimer);
    vCardDelayTimer = setTimeout(function () {
        //console.log("Delay done");
        if (!$("#" + divId).length) {
            //console.log("Create and load VCard");
            $("body").append('<div id="' + divId + '" class="hidden"></div>');
            $.ajax({
                type: 'POST',
                url: vCardLoadUrl,
                data: {'contentContainerId': contentContainerId},
                success: function (response) {
                    //console.log("Loading done");
                    $("#" + divId).html(response);

                    if (response != '') {
                        showPopOver(trigger, response);
                    }
                }
            });
        } else {
            //console.log("Use cached");
            showPopOver(trigger, $("#" + divId).html());
        }
    }, vCardDelay);
});


$(document).on('mouseleave', '[data-contentcontainer-id]', function () {
    clearTimeout(vCardDelayTimer);

    var that = this;
    setTimeout(function () {
        if (!$('.popover:hover').length) {
            $(that).popover('hide');
        }
    }, 300);

});

function showPopOver(trigger, content) {
    var $trigger = $(trigger);
    var $content = $(content);

    $popover = $trigger.popover({
        trigger: 'manual',
        html: true,
        placement: 'auto left',
        container: 'body',
        content: content,
        animation: true
    }) .data('bs.popover').tip().addClass('vcardPopover');

    $trigger.popover('show');

    // Popover seems to get rid of inline styles, so we replace the content
    $popover.find('.vcardContent').replaceWith($content.find('.vcardContent'));

    // Make sure the image itself is not a popover target
    $popover.find('[data-contentcontainer-id]').removeAttr('data-contentcontainer-id');

    $('.vcardPopover').one('mouseleave', function () {
        $trigger.popover('hide');
    });
}