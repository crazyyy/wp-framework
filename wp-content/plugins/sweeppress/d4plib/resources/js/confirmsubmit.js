/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

;(function($, window, document, undefined) {
    var ConfirmSubmit = function(elem, options) {
        this.elem = elem;
        this.$elem = $(elem);
        this.options = options;

        this.metadata = this.$elem.data("confirm-submit");
    };

    ConfirmSubmit.prototype = {
        defaults: {},

        init: function() {
            this.config = $.extend({}, this.defaults, this.options, this.metadata);
            this.save();

            var $this = this;

            this.$elem.submit(function() {
                $this.save();
            });

            $(window).on('beforeunload', function(e) {
                if ($this.$elem.data("form-state-original") !== $this.$elem.serialize()) {
                    e.preventDefault();
                    e.returnValue = '';

                    return false;
                }
            });
        },
        save: function() {
            this.$elem.data("form-state-original", this.$elem.serialize());
        }
    };

    ConfirmSubmit.defaults = ConfirmSubmit.prototype.defaults;

    $.fn.confirmsubmit = function(options) {
        return this.each(function() {
            new ConfirmSubmit(this, options).init();
        });
    };
})(jQuery, window, document);
