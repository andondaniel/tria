<?php
  /*** to add placeholder in loginform ***/

  if ( !function_exists( 'wen_login_scripts' ) ):
  function wen_login_scripts(){


    wp_enqueue_style( 'wen-login', get_stylesheet_directory_uri().'/'. WEN_FRAMEWORK_BASEPATH.'/custom-login/custom-login.css', false, '', 'all' );
    wp_enqueue_script( 'wen-modernizr', get_stylesheet_directory_uri() .'/'. WEN_FRAMEWORK_BASEPATH.'/custom-login/js/modernizr.js', array('jquery'), '', true );


  }
  endif; //endif
  add_action( 'login_enqueue_scripts', 'wen_login_scripts' );

  /**** to change href of logo in backend login ******/
  if ( !function_exists( 'wen_login_logo_url' ) ):
    function wen_login_logo_url() {
        return esc_url( home_url( '/' ) );
    }
  endif; //endif wen_login_logo_url
  add_filter( 'login_headerurl', 'wen_login_logo_url' );

  /**** to change link title property ******/
  if ( !function_exists( 'wen_login_logo_url_title' ) ):
    function wen_login_logo_url_title() {
      return get_bloginfo( 'name', 'display' );
    }
  endif; //endif wen_login_logo_url_title

  add_filter( 'login_headertitle', 'wen_login_logo_url_title' );


  /**** Add scripts in head  ******/
  function wen_login_head_custom(){

    $login_logo_url = esc_url( apply_filters('wen_filter_login_logo_url', get_stylesheet_directory_uri() . '/' . WEN_FRAMEWORK_BASEPATH . '/custom-login/images/logo-login.png') );
    ?>
    <style>
      body.login div#login h1 a {

          background-image: url("<?php echo $login_logo_url?>");


      }
    </style>
        <script type="text/javascript">

                $ = jQuery;

                $(document).ready(function(){

                      $('#loginform').find('input[name="log"]').each(function(ev){

                          if(!$(this).val()) {

                            $(this).attr("placeholder", "Username");

                          }

                      });

                      $('#loginform').find('input[name="pwd"]').each(function(ev){

                            if(!$(this).val()) {

                                $(this).attr("placeholder", "Password");

                            }

                      });

              if(!Modernizr.input.placeholder){

              $('[placeholder]').focus(function() {

                var input = $(this);

                if (input.val() == input.attr('placeholder')) {

                input.val('');

                input.removeClass('placeholder');

                }

              }).blur(function() {

                var input = $(this);

                if (input.val() == '' || input.val() == input.attr('placeholder')) {

                input.addClass('placeholder');

                input.val(input.attr('placeholder'));

                }

              }).blur();

              $('[placeholder]').parents('form').submit(function() {

                $(this).find('[placeholder]').each(function() {

                var input = $(this);

                if (input.val() == input.attr('placeholder')) {

                  input.val('');

                }

                })

              });

            }

                });

            </script>
    <?php
  } //end function wen_login_head_custom
  add_action( 'login_head', 'wen_login_head_custom' );

  /**** to remove labels of login form  ******/

  global $pagenow;

  if ($pagenow==='wp-login.php') {

    add_filter( 'gettext', 'wen_user_email_login_text', 20, 3 );

    function wen_user_email_login_text( $translated_text, $text, $domain ) {

      if ( isset( $_REQUEST['action'] ) ) {

        return $translated_text;

      }

      if ($translated_text === 'Username') {

        $translated_text = '';

      }

      if ($translated_text === 'Password') {

        $translated_text = '';

      }

      return $translated_text;
    } // end function

  }

