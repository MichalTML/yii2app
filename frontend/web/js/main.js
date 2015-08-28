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
    $('.parts-button').click(function(){
        $('#parts-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
});


