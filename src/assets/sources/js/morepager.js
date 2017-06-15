(function ($) {
    "use strict";

    $.fn.pager = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.pager');
            return false;
        }
    };

    var pagerData = {}, methods = {
        init: function (options) {
            return this.each(function () {
                var pager = $(this), pagerId = pager.attr('id');
                if (pagerData[pagerId] === undefined) {
                    pagerData[pagerId] = $.extend({}, {settings: options || {}});
                } else {
                    return;
                }

                var contentSelector = pagerData[pagerId].settings.contentSelector;
                pager.parents(contentSelector).on('click.pager', '[data-action="load"]', {
                    pagerId: pagerId,
                    contentSelector: contentSelector,
                    onLoad: pagerData[pagerId].settings.onLoad,
                    onAfterLoad: pagerData[pagerId].settings.onAfterLoad
                }, load);
            });
        }
    };

    /**
     * Load comments list
     * @param eventParams
     */
    function load(eventParams) {
        var onLoad = eventParams.data.onLoad;
        var onAfterLoad = eventParams.data.onAfterLoad;
        var contentSelector = eventParams.data.contentSelector;
        var pagerId = '#' +eventParams.data.pagerId;
        var url = $(pagerId).find('a').data('url');

        if (url.length > 0) {
            if (onLoad) {
                onLoad(eventParams);
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    $(pagerId).remove();
                    $(contentSelector).append(
                        $(response).find(contentSelector)
                    );
                }
            });

            if (onAfterLoad) {
                onAfterLoad(eventParams);
            }
        }

        return false;
    }

})(window.jQuery);
