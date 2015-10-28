/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
        $('.content-box').css('transition', '4s');
        $('.content-box').css('margin-top', '-50px');

    });
    
$(document).ajaxStart(function() {
    $("body").prepend("<div class=\"overlay\"></div>");
    $(".overlay").css({
    "position": "absolute", 
    "width": $(document).width(), 
    "height": $(document).height(),
    "z-index": 99999 
    }).fadeTo(0, 0.8);
});
    
$(document).ajaxStop(function() {
        $('.overlay').fadeOut('slow'); 
        $('.overlay').remove();
        
});
 


$(function() {
  $(".pdff-button").click(function() {
    var productLink = $(this).find("a");

    productLink.attr("target", "_blank");
    window.open(productLink.attr('value'));
 
    return false;
  });
});

$(function() {
  // get the click event of the Note button
    $('.file-button').click(function(){
        $('#file-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});

$(document).on('pjax:complete', function() {
    // get the click event of the Note button
    $('.file-button').click(function(){
        $('#file-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});

$(document).ready(function(){
   $('#upload-button').click(function(){
       $('#upload-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
   });
    
});

$(document).ready(function(){
    var table = [];
    $('.treatment-row').each(function(){
       var temp = $(this).data('key');
       var sygnature = $('.treatment-row[data-key=' + temp + '] td:first-child').html();
      $('.treatment-row[data-key=' + temp + ']').mouseenter(function(){
         $('.treatment-row[data-key=' + temp + '] td').addClass('highlight'); 
      });
      $('.treatment-row[data-key=' + temp + ']').mouseleave(function(){
         $('.treatment-row[data-key=' + temp + '] td').removeClass('highlight'); 
      });
      $('.treatment-row[data-key=' + temp + ']').click(function(){
          url = "/index.php?r=project%2Ftreatmentmanager&sygnature=" + sygnature + "&id=" + temp;
          window.location = url;
      });
   });       
});

$(document).ready(function(){
   $('.lighted-row').each(function(){
       $(this).children().last().hover(
            function() {
                $(this).parent().addClass('light-on');
            }, function() {
                $(this).parent().removeClass('light-on');
             }
        );
   });
});


