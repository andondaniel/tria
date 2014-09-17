jQuery(document).ready(function($){



  $('.layout-buttons-wrap .btn-view-change').on('click',function(e){
    e.preventDefault();
    $this = $(this);
    var is_active = $this.hasClass('btn-selected');
    if ( true === is_active) {
      return;
    };
    $this.parent().find('a').removeClass('btn-selected');
    $this.addClass('btn-selected');

    // Change class in wrapper
    var selected_view = $this.data('view');
    $('#blog-content-wrap').removeClass().addClass( selected_view + '-wrap' );


  });

  // Trigger initial layout
  $('.layout-buttons-wrap a:first').trigger('click');

});
