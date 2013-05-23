(function (window, $) {
    'use strict';

    var
        modified = false,
        bindEvents = 'keyup change paste',
        $slugField, $titleField;

    function populate_slug() {
        if (!modified) {
            // Grab title field and send it to function for processing
            var
                value = $titleField.val(),
                slug = window.convert_text_to_url(value);

            // Set the slug field value to the parsed value
            $slugField.val(slug);
        }
    }

    $(function () {
        // Initialize jQuery objects
        $slugField = $('#Gallery_Set_Item_slug');
        $titleField = $('#Gallery_Set_Item_title');

        /*
         * Only bind to the specified events if the title field is blank.
         * When that is the case, we know that a new gallery set is being
         * created and any existing slug won't be overwritten.
         */
        if ($slugField.val() === '') {
            $titleField.bind(bindEvents, function () { populate_slug(); });

            /*
             * When the slug is modified independently from the title, we
             * need to abandon populating it with a sanitized slug
             */
            $slugField.bind('change', function () { modified = true; });
        }
    });
}(this, this.jQuery));
