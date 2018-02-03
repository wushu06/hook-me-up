jQuery(document).ready(function ($) {

    $('ul.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });



});
jQuery(document).ready( function($){

    var mediaUploader;

    $('#upload-button').on('click',function(e) {
        e.preventDefault();
        if( mediaUploader ){
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose a Profile Picture',
            button: {
                text: 'Choose Picture'
            },
            multiple: false
        });

        mediaUploader.on('select', function(){
            attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#profile-picture').val(attachment.url);
            $('#profile-picture-preview').css('background-image','url(' + attachment.url + ')');
        });

        mediaUploader.open();

    });

    $('#remove-picture').on('click',function(e){

    });



});
jQuery(document).ready( function($){
    function showDataTable(){

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'save_sort'

            },
            error: function( error ) {
                console.log('ERROr');
            },
            success:function(data){

               console.log('suc'+data);
            }
        });

    }

    $('#importTable').on('submit', function(e){
        e.preventDefault();
        showDataTable()
    });
});


