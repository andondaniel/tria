jQuery(function($) {

    // Featured Doctor
    jQuery('.btn-featured-doctor').click(function() {
        var selected = 'yes';
        if ( jQuery(this).hasClass( 'selected' ) ){
            jQuery(this).removeClass( 'selected' );
            selected = 'no';
        } else { jQuery(this).addClass( 'selected' ); }
        // get id
        var tempID = jQuery(this).attr( 'id' );
            tempID = tempID.split( '_' );
        jQuery.post( ajaxurl, 'action=tria_doctor_featured&post='+tempID[1]+'&ns_featured='+selected );

    });

    //////////////////////////////////////////

    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-')
            ;
    }

    //  Dialog
    var $dfDialog = $(".wen-df-dialog");
    var $ctDialog = $(".wen-custom-dialog");

    // doctor filter STARTS

    if($("#find-a-doctor-selection").length > 0){

        //  Listen the Add Click
        $(".add-new-doctor-filter").click(function(e){
            e.preventDefault();
            //  Create the New Element
            var $li = $('<li></li>');

            //  Add Class to Element
            $li.addClass('df-item');

            //  Create the Element Label
            var $label = $('<label></label>');
            //  Set Contents for the Label
            // $label.append('<span class="item-icon">&nbsp;</span>');
            $label.append('<span class="item-name">New Item</span>');
            // $label.append('<a href="#" class="df-item-delete" title="Delete">X</a>');
            //  Set Contents
            $li.append($label);
            var rand_num = Math.random() * 1000;


            $li.append('<input type="hidden" value="N" name="selection_tools[enabled]['+ rand_num +']" />');
            $li.append('<input type="checkbox" value="Y" name="selection_tools[enabled]['+ rand_num +']" />');
            //  Add Hidden Fields
            $li.append('<input type="hidden" name="selection_tools[label][]" class="hidden-df-title" value="New Item" />');
            $li.append('<input type="hidden" name="selection_tools[slug][]" class="hidden-df-slug" />');
            $li.append('<button class="btn-remove-provider-filter">X</button>');
            //  Append to Container
            $(this).parent().find('.wen-df-list').append($li);
            //  Trigger Click
            $li.trigger('click');





        });

        // Listen remove provider filter
        $('body').on('click','.btn-remove-provider-filter',function(e){
            var confirmation = confirm('Are you sure?');
            if( ! confirmation){
                return false;
            }
            $(this).parent().remove();
            e.preventDefault();
            // alert('asdf');
        });





        // Listen to Click event
        $(".wen-df-list").on('click', '.df-item', function() {
            // console.log('hello');
            //  This Item
            var $thisItem = $(this);
            //  Remove Active State
            $(".wen-df-list>li").removeClass('item-active');

            //  Add the Class
            $thisItem.addClass('item-active');
            //  Read Data
            var theTitle = $thisItem.find('.hidden-df-title').val();
            console.log(theTitle);
            //  Populate
            if(theTitle && theTitle != undefined)
                $dfDialog.find('.df-title').val(theTitle);
            else
                $dfDialog.find('.df-title').val('');
            //  Show the Dialog
            $dfDialog.css({
                top: ($thisItem.offset().top - 32) + 'px',
                left: ($thisItem.offset().left + ($thisItem.width() / 2) - 24) + 'px',
            }).fadeIn(500);
            //  focus on element
            $dfDialog.find('.df-title').focus();
        });

        //  Listen the Cancel Dialog Click
        $dfDialog.find('.cancel-df-data').click(function(e) {

            //  Close Dialog
            $dfDialog.fadeOut(300, function() {

                //  Remove Active State
                $(".wen-df-list>li").removeClass('item-active');
            });

            //  Prevent Default
            e.preventDefault();
            return false;
        });


        //  Listen the Submit Dialog Click
        $dfDialog.find('.submit-df-data').click(function(e) {

            //  New Title & URL
            var newTitle = $dfDialog.find('.df-title').val();

            //  Get Active Element
            var $activeElem = $(".wen-df-list>li.item-active:first");

            //  Store Values to Hidden Fields
            $activeElem.find('.hidden-df-title').val(newTitle);

            //  Update Label
            $activeElem.find('.item-name').html(newTitle);

            //  Close Dialog
            $dfDialog.fadeOut(300, function() {

                //  Remove Active State
                $(".wen-df-list>li").removeClass('item-active');
            });

            //  Prevent Default
            e.preventDefault();
            return false;
        });




    }

    // doctor filter ENDS

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

            //  focus on element
            $ctDialog.find('.ct-title').focus();
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
            var newTitleText = $ctDialog.find('.ct-title option:selected').text();

            //  Get Active Element
            var $activeElem = $(".wen-custom-list>li.item-active:first");

            //  Store Values to Hidden Fields
            $activeElem.find('.hidden-ct-title').val(newTitle);
            $activeElem.find('.hidden-ct-url').val(newURL);

            //  Update Label
            $activeElem.find('.item-name').html(newTitleText);

            //  Check for Icon
            if(newURL != '')
                $activeElem.find('.item-icon').html('<img src="' + newURL + '" alt="" />');
            else
                $activeElem.find('.item-icon').html('&nbsp;');

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
