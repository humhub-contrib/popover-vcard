/*
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */


humhub.module('vcard.popover', function (module, require, $) {

    var client = require('client');

    var vCardDelayTimer;
    var activePopovers = new Map(); // Track active popovers

    module.initOnPjaxLoad = true;

    function init(pjax) {
        $('.vcardPopover').remove();

        // Dispose of existing popovers
        activePopovers.forEach(function(popover, element) {
            if (popover) {
                popover.dispose();
            }
        });
        activePopovers.clear();

        if (pjax) {
            return;
        }

        $(document).on('mouseenter', '[data-contentcontainer-id],[data-contentcontainer-guid]', function () {

            if(ignoreElement(this)) {
                return;
            }

            var trigger = this;
            var selector = '#' + getVCardId(trigger);
            clearTimeout(vCardDelayTimer);
            vCardDelayTimer = setTimeout(function () {
                if (!$(selector).length) {
                    createPopover(trigger)
                } else {
                    showPopOver(trigger, $(selector).html());
                }
            }, module.config.delay);
        });

        $(document).on('mouseleave', '[data-contentcontainer-id],[data-contentcontainer-guid]', function () {
            if(ignoreElement(this)) {
                return;
            }

            clearTimeout(vCardDelayTimer);

            var trigger = this;
            setTimeout(function () {
                if (!$('.popover:hover').length) {
                    hidePopover(trigger);
                }
            }, 300);
        });
    }

    function ignoreElement(elem)
    {
        return $(elem).closest('#user-account-image, #space-menu-dropdown, #space-menu, .profile-user-photo-container').length;
    }

    function getVCardId(trigger) {
        var contentContainerId = $(trigger).data('contentcontainer-id');
        var contentContainerGuid = $(trigger).data('contentcontainer-guid');
        return 'vCard' + (contentContainerId || contentContainerGuid);
    }

    function createPopover(trigger) {
        var $trigger = $(trigger);
        var vCardId = getVCardId(trigger);
        var contentContainerId = $trigger.data('contentcontainer-id');
        var contentContainerGuid = $trigger.data('contentcontainer-guid');

        $("body").append('<div id="' + vCardId + '" class="d-none"></div>');

        var data = {
            guid: contentContainerGuid,
            id: contentContainerId
        };

        client.post(module.config.loadUrl, {data: data}).then(function (response) {
            if (response.html) {
                $("#" + vCardId).html(response.html);
                showPopOver(trigger, response.html);
            }
        }).catch(function (e) {
            module.log.error(e);
        });
    }

    function showPopOver(trigger, content) {
        var $trigger = $(trigger);
        var $content = $(content);

        // Dispose of existing popover for this trigger
        if (activePopovers.has(trigger)) {
            activePopovers.get(trigger).dispose();
        }

        // Create new popover instance
        var popover = new bootstrap.Popover(trigger, {
            trigger: 'manual',
            html: true,
            placement: 'auto',
            container: 'body',
            content: content,
            animation: true,
            customClass: 'vcardPopover'
        });

        // Store the popover instance
        activePopovers.set(trigger, popover);

        // Show the popover
        popover.show();

        // Get the popover element after it's shown
        var popoverElement = document.querySelector('.popover.vcardPopover:last-child');
        if (popoverElement) {
            var $popover = $(popoverElement);

            // Popover seems to get rid of inline styles, so we replace the content
            $popover.find('.vcardContent').replaceWith($content.find('.vcardContent'));

            // Make sure the image itself is not a popover target
            $popover.find('[data-contentcontainer-id]').removeAttr('data-contentcontainer-id');

            // Add mouseleave handler to popover
            $popover.one('mouseleave', function () {
                hidePopover(trigger);
            });
        }
    }

    function hidePopover(trigger) {
        var popover = activePopovers.get(trigger);
        if (popover) {
            popover.hide();
        }
    }

    module.export({
        init: init
    });

});
