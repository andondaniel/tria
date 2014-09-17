jQuery(function($) {

    //  Remove Empty ACF Field
    $("#acf-field-").each(function() {
        $(this).parent().parent().next().remove();
        $(this).parent().parent().remove();
    });

    //  Run Accordion
    $("#inline-archives-holder").accordion();

    //  Listen the Add Click
    $(".ajax-add-subpost").click(function(e) {

        //  Ajax Form
        var $ajaxForm = $(this).parent().parent().parent();

        //  Serialize the Form Fields
        var serializedFormData = $ajaxForm.find(':input, select, textarea').filter(function() { return (String($(this).attr('name')).substr(0, 7) != 'fields['); }).serializeArray();
        var serializedHiddenData = $ajaxForm.next().find('input:hidden').serializeArray();

        //  Data to Send
        var dataToSend = createProperDataHash($.extend({}, serializedHiddenData, {form_data: serializedFormData}));

        //  Create Space for ACF Fields
        dataToSend['form_data']['acf_fields'] = {};

        //  Get Data from ACF Fields
        $ajaxForm.find('[data-field_name]').each(function() {

            //  Add
            dataToSend.form_data['acf_fields'][$(this).data('field_name')] = $(this).data('field_key');
            dataToSend.form_data[$(this).data('field_name')] = $(this).find(':input, select, textarea').val();
        });

        //  Send the AJAX Request
        $.ajax({
            data: dataToSend,
            dataType: 'json',
            method: 'POST',
            url: CPTE_OBJECT.ajax_url + '?action=cpte-subpost-submit',
            success: function(response) {

                //  Scroll to Form
                $('html, body').animate({
                    scrollTop: $(".cpte-messages-panel").offset().top - 90
                });

                //  Check Any Timeout
                if($ajaxForm.data('timeClear')) {

                    //  Clear
                    clearTimeout($ajaxForm.data('timeClear'));
                    $ajaxForm.data('timeClear', null);
                }

                //  Append Message
                $ajaxForm.find('.cpte-messages-panel').html(response.message).show(0);

                //  Check Success
                if(response.success) {

                    //  Clear Inputs
                    $ajaxForm('.clear-inline-subpost').click();

                    //  Set Timer
                    $ajaxForm.data('timeClear', setTimeout($.proxy(function() {

                        //  Fadeout the Message Panel
                        $(this).find('.cpte-messages-panel').fadeOut('slow', function() {

                            //  Clear
                            $(this).html('');
                        });
                    }, $ajaxForm), 5000));
                }
            },
            error: function() {
                //  Do Nothing for now
            }
        });

        //  Prevent Default
        e.preventDefault();
        return false;
    });

    //  Listen the Clear Click
    $(".clear-inline-subpost").click(function(e) {

        //  Ajax Form
        var $ajaxForm = $(this).parent().parent().parent();

        //  Clear Inputs
        $ajaxForm.find(':input, select, textarea').filter(function() { return ($(this).attr('type') != 'button'); }).val('');

        //  Try Tinymce Clear
        try {
            tinyMCE.activeEditor.setContent('');
            //tinyMCE.triggerSave();
        } catch(e) {}

        //  Prevent Default
        e.preventDefault();
        return false;
    });

    //  Process Hash Requests
    processHashRequests();

    //  Check
    if($("#inline-add-post").length > 0) {

        //  Listen the Submit Click
        $("input#publish").click(function(e) {

            //  Disable All Fields
            $("#inline-add-post").find('input, textarea, select').attr('disabled', true);
        });
    }

    //  Check Defined
    if(window["HOOK_PAGE_FIELDS"] != undefined) {

        //  Field Settings
        var fieldSettings;

        //  Loop Each
        for(var fieldID in HOOK_PAGE_FIELDS) {

            //  Field Settings
            fieldSettings = HOOK_PAGE_FIELDS[fieldID];

            //  Search
            if($("#" + fieldID).length > 0) {

                //  Get the Element
                var $tElem = $("#" + fieldID);

                //  Check for Change
                if(fieldSettings['change'] != undefined) {

                    //  Change ID
                    $tElem.attr('id', fieldSettings['change']);
                }

                //  Check for Duplicate Creation
                if(fieldSettings['duplicate'] != undefined) {

                    //  New Element
                    var $newElem = $("<textarea></textarea");

                    //  Set Attributes
                    $newElem.attr('name', fieldSettings['duplicate']);

                    //  Hide the Elem
                    $newElem.css({
                        display: 'none',
                        visibility: 'hidden',
                        width: 0,
                        height: 0
                    });

                    //  Append After the target Element
                    $tElem.after($newElem);

                    //  Listen for Change
                    $tElem.keyup(function() {

                        //  Update Value
                        $newElem.val($(this).val());
                    }).keyup();
                }
            }
        }
    }
});

//  Create Proper Data Hash
function createProperDataHash(data) {

    //  Output
    var output = {};

    //  Def
    var thisObject;

    //  Loop each
    for(var i in data) {

        //  This Object
        thisObject = data[i];

        //  Check for Deep Object
        if(thisObject['name'] != undefined && thisObject['value'] != undefined) {

            //  Store
            output[thisObject.name] = thisObject.value;
        } else {

            //  Re-Loop
            output[i] = createProperDataHash(thisObject);
        }
    }

    //  Return
    return output;
}

//  Process Hash Requestes
function processHashRequests() {

    //  Read Location Hash
    var locationHashData = parseLocationHash();

    //  Check for Top Level Page Filter
    if(locationHashData['tpage'] != undefined) {

        //  Get the Menu ID
        var menuID = 'toplevel_page_' + locationHashData['tpage'];

        //  Find
        if(jQuery("#" + menuID).length > 0) {

            //  Remove Any Active
            jQuery("#adminmenu>li")
                    .removeClass('wp-menu-open')
                    .removeClass('wp-has-current-submenu')
                    .removeClass('opensub')
                    .addClass('wp-not-current-submenu');
            jQuery("#adminmenu>li>a")
                    .removeClass('wp-menu-open')
                    .removeClass('wp-has-current-submenu');
            jQuery("#adminmenu>li> .wp-submenu>li").removeClass('current');

            //  Set Active
            jQuery("#" + menuID).addClass('current');
        }
    }
}

//  Parse Location Hash Data
function parseLocationHash() {

    //  Data
    var data = {};

    //  Hash Data
    var hashData = (location.hash.substr(0, 1) == '#' ? location.hash.substr(1) : '');

    //  Splits
    var splits = hashData.split('&');

    //  Loop Each
    for(var i in splits) {

        //  Split Again
        var thisSplit = splits[i].split('=');

        //  Store
        data[thisSplit[0]] = (thisSplit.length > 1 ? thisSplit[1] : null);
    }

    //  Return
    return data;
}