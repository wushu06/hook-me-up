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
        var file_csv = $('#locationUpload').prop('files')[0];

        var form_data = new FormData();

        form_data.append('file', file_csv);
        form_data.append('action', 'hook_me_up_upload_csv_file');


        $.ajax({
            type: 'POST',
            url: ajaxurl,

            contentType: false,
            processData: false,
            data: form_data,

            success:function(data){
                $('.output-table').append(data);
                console.log(data);
            }
        });

    }

    $('#importTable').on('submit', function(e){
        e.preventDefault();
        showDataTable()
    });
});


