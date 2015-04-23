/* ========================================================================
* MODALS
* ======================================================================== */

+function ($) {
  'use strict';

  $('#videoLink').click(function() {
  	var youtubeId = $(this).attr('data-youtube');

  	$('.modal-content').html('<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' + youtubeId + '?autoplay=1&controls=1&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe>')
  	$('#videoModal').modal();
  });

  $('#videoModal').on('hide.bs.modal', function () {
  	$('div.modal-content').html('');
  });
  	
}(jQuery);
