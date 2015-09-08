/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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