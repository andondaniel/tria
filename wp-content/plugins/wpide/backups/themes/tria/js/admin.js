jQuery(function($) {

    //  Dialog
    var $ctDialog = $(".wen-custom-dialog");

    //  Check for Treatments Page
    if($("#treatments-selection").length > 0) {

        //  Listen the Add Click
        $(".add-new-ct").click(function(e) {

            //  Create the New Element
            var $li = $('<li></li>');

            //  Add Class to Element
            $li.addClass('ct-item');

            //  Create the Element Label
            var $label = $('<label></label>');

            //  Set Contents for the Label
            $label.append('<span class="item-icon">&nbsp;</span>');
            $label.append('<span class="item-name">New Item</span>');
            $label.append('<a href="#" class="ct-item-delete" title="Delete">X</a>');

            //  Set Contents
            $li.append($label);

            //  Add Hidden Fields
            $li.append('<input type="hidden" name="wizard_tools[title][]" class="hidden-ct-title" value="New Item" />');
            $li.append('<input type="hidden" name="wizard_tools[url][]" class="hidden-ct-url" />');

            //  Append to Container
            $(this).prev().append($li);

            //  Trigger Click
            $li.trigger('click');

            //  Prevent Default
            e.preventDefault();
            return false;
        });

        //  Listen the Delete Click
        $(".wen-custom-list").on('click', '.ct-item-delete', function(e) {

            //  Confirm
            if(confirm('Are you sure to remove this item ?')) {

                //  Check for Active
                var isActive = $(this).parent().parent().hasClass('item-active');

                //  Close Dialog if Active
                if(isActive) {

                    //  Trigger the Cancel
                    $ctDialog.find('.cancel-ct-data').trigger('click');
                }

                //  Clear the Item
                $(this).parent().parent().fadeOut('slow', function() {

                    //  Remove the Element
                    $(this).remove();
                });
            }

            //  Prevent Default
            e.preventDefault();
            return false;
        });

        //  Listen Click on CT Item
        $(".wen-custom-list").on('click', '.ct-item', function() {

            //  This Item
            var $thisItem = $(this);

            //  Remove Active State
            $(".wen-custom-list>li").removeClass('item-active');

            //  Add the Class
            $thisItem.addClass('item-active');

            //  Read Data
            var theTitle = $thisItem.find('.hidden-ct-title').val();
            var theURL = $thisItem.find('.hidden-ct-url').val();

            //  Populate
            if(theTitle && theTitle != undefined)
                $ctDialog.find('.ct-title').val(theTitle);
            else
                $ctDialog.find('.ct-title').val('');
            if(theURL && theURL != undefined)
                $ctDialog.find('.ct-url').val(theURL);
            else
                $ctDialog.find('.ct-url').val('');

            //  Show the Dialog
            $ctDialog.css({
                top: ($thisItem.offset().top - 32) + 'px',
                left: ($thisItem.offset().left + ($thisItem.width() / 2) - 24) + 'px',
            }).fadeIn(500);
        });

        //  Listen Media Picker Click
        $(".ct-pick-from-media").click(function(e) {

            //  Configure Media Picker
            wp.media.editor.send.attachment = function(props, attachment) {

                //  Store 
                $ctDialog.find('.ct-url').val(attachment.url);
            }

            //  Launch Media Picker
            wp.media.editor.open(this);

            //  Prevent Default
            e.preventDefault();
            return false;
        });

        //  Listen the Submit Dialog Click
        $ctDialog.find('.submit-ct-data').click(function(e) {

            //  New Title & URL
            var newTitle = $ctDialog.find('.ct-title').val();
            var newURL = $ctDialog.find('.ct-url').val();

            //  Get Active Element
            var $activeElem = $(".wen-custom-list>li.item-active:first");

            //  Store Values to Hidden Fields
            $activeElem.find('.hidden-ct-title').val(newTitle);
            $activeElem.find('.hidden-ct-url').val(newURL);

            //  Update Label
            $activeElem.find('.item-name').html(newTitle);

            //  Check for Icon
            if(newURL != '')
                $activeElem.find('.item-icon').html('<img src="' + newURL + '" alt="" />');
            else
                $activeElem.find('.item-icon').html('');

            //  Close Dialog
            $ctDialog.fadeOut(300, function() {

                //  Remove Active State
                $(".wen-custom-list>li").removeClass('item-active');
            });

            //  Prevent Default
            e.preventDefault();
            return false;
        });

        //  Listen the Cancel Dialog Click
        $ctDialog.find('.cancel-ct-data').click(function(e) {

            //  Close Dialog
            $ctDialog.fadeOut(300, function() {

                //  Remove Active State
                $(".wen-custom-list>li").removeClass('item-active');
            });

            //  Prevent Default
            e.preventDefault();
            return false;
        });
    }

    //  Check for Speaker ID Field
    $(".field[data-field_name=speaker_id]").each(function() {

        //  Input Control
        var $thisControl = $(this);

        //  Init Select2
        $thisControl.find('select:first').select2({
            placeholder: "Select a Speaker"
        });
    });
});