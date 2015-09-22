/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Hide it initially
    $("body").prepend("<div class=\"overlay\"></div>");
    
    $(".overlay").css({
    "position": "absolute", 
    "width": $(document).width(), 
    "height": "2000px",
    "z-index": 99999
    });
    $(".overlay").hide();
$(document).ajaxStart(function() {
        $("body").css("overflow", "hidden");
        $(".overlay").fadeIn("fast"); 
     });
    $(document).ajaxStop(function() {
        
        $(".overlay").fadeOut("slow"); 
        $("body").css("overflow", "scroll");
    });
    
$(function(){
    // get the click event of the Note button
    $('.note-button').click(function(){
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});

$(function(){
    // get the click event of the Note button
    $('.seenote-button').click(function(){
        $('#file-notes-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});

$(function(){
    // get the click event of the Note button
    $('.view-button').click(function(){
        $('#view-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});

$(function(){
    // get the click event of the Note button
    $('.client-button').click(function(){
        $('#client-modal').modal('show')
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



