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
        
});
 
$(function(){
    // get the click event of the Note button
    $('.seenote-button').click(function(){
        $('#file-notes-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
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



