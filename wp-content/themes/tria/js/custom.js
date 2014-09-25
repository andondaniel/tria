
jQuery(document).ready(function($) {

    // Trigger lazy load
    $("img.lazy").lazyload();

    // Search click
    $('#btn-main-search-button').click(function(e){
        e.preventDefault();
        var keyword = $('#main-search-form input').val();
        if ('' != keyword) {
            var surl = JS_TRIA.site_url +'?s='+ keyword;
            window.location = surl;
        }
    });

    // Provider load more
    jQuery("#btn-load-more-provider").on('click',function(e){
      e.preventDefault();
      var $this = $(this);
      // console.log($this.data());
      // alert('Please load more');
      var dataObject = new Object();
      dataObject.filters        = $this.data();
      dataObject.action        = 'load_more_provider';
      // dataObject.next_page = $this.data('next-page');
      if ( 0 == dataObject.next_page ) {
        return false;
      }
      // console.log(dataObject);return;
      jQuery.ajax({
        method: 'POST',
        url : TRIA_OBJ.ajax_url,
        data : dataObject,
        beforeSend: function(){
            $('#loading-provider').show();
        },
        success: function(response){

            $('#loading-provider').hide();

            if ( 1 == response.success ) {
                if( 1 == response.has_content){

                    $('#container-providers').append(response.content);
                    $("img.lazy",'#container-providers').lazyload();

                }
                if( 1 == response.has_next_page){

                    $this.data('next_page',response.next_page);

                }
                else{
                    $this.data('next_page',0);
                    $this.parent().addClass('hide-me');
                }


            }

        }
      });

    });




    // Slider
    $('.responsive').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.multiple-items').slick({
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1
    });

    //  Listen Newsletter Form Submit
    $('.mailing-subscribe-form').submit(function(e) {

        //  This Form
        var $thisForm = $(this);

        //  Email Input
        var $emailInput = $thisForm.find('.email');

        //  Remove the Messages
        $thisForm.parent().find('.subscribe-error, .subscribe-success').remove(0);

        //  Check
        if($emailInput.val().length == 0) {

            //  Append Error
            if($thisForm.prev().is('.subscribe-error'))
                $thisForm.prev().html('Email Address is required');
            else
                $thisForm.before('<p class="subscribe-error">Email Address is required</p>');
        } else {

            //  Data String to Send
            var dataStr = $(this).serialize();

            //  Add Action
            dataStr += '&action=wen-newsletter-subscribe';

            //  Create the AJAX Request
            $.ajax({
                url: TRIA_OBJ.ajax_url,
                data: dataStr,
                dataType: 'json',
                method: 'POST',
                success: function(response) {

                    //  Validate
                    if(response.success) {

                        //  Success Message
                        var successMsg = response.msg != undefined ? response.msg : 'Subscription successful';

                        //  Display Success
                        if($thisForm.prev().is('.subscribe-success'))
                            $thisForm.prev().html(successMsg);
                        else
                            $thisForm.before('<p class="subscribe-success">' + successMsg + '</p>');

                        //  Clear Input
                        $emailInput.val('');
                    } else {

                        //  Error Message
                        var errorMsg = response.msg != undefined ? response.msg : 'Error! Please try again later';

                        //  Display Error
                        if($thisForm.prev().is('.subscribe-error'))
                            $thisForm.prev().html(errorMsg);
                        else
                            $thisForm.before('<p class="subscribe-error">' + errorMsg + '</p>');
                    }
                }
            });
        }

        //  Prevent Default
        e.stopImmediatePropagation();
        e.preventDefault();
        return false;
    });

});
