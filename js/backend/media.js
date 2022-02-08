$ = jQuery;
var pubsMediaLibrary;
var uploadInput;

$(document).ready(function () {
    // Custom Media Library Functions
    pubsMediaLibrary = getPUBSRMBLMediaLibrary();

    pubsMediaLibrary.on('select', function () {
        // write your handling code here.
        var selectedItems = pubsMediaLibrary.state().get('selection');
        var selectedItemID = '';
        var selectedItemURL = '';

        selectedItems.each(function (attachment) {
            selectedItemID = attachment['id'];
            selectedItemURL = attachment.attributes['url'];
        });

        uploadInput.data("kendoTextBox").value(selectedItemURL);
        uploadInput.data("kendoTextBox").trigger('change');

        /*
        $("input[name='Image_id']").val(selectedItemID).change();
        if (selectedImageID != null) {
            $("#catalog-image-span").show();
            $("#catalog-image").show();
            $("#remove-image-btn").show();
            $("#add-image-btn").text('Change Image');
            $("#catalog-image").attr("src", selectedImageThumbnailURL);
        }
        */
    });

});

function getPUBSRMBLMediaLibrary() {
    pubsMediaLibrary = window.wp.media({

        // Accepts [ 'select', 'post', 'image', 'audio', 'video' ]
        // Determines what kind of library should be rendered.
        frame: 'select',

        // Modal title.
        title: "'Select Document'",

        // Enable/disable multiple select
        multiple: false,

        // Library wordpress query arguments.
        library: {
            order: 'DESC',

            // [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo', 'id', 'post__in', 'menuOrder' ]
            orderby: 'date',

            // mime type. e.g. 'image', 'image/jpeg'
            type: 'application/pdf',

            // Searches the attachment title.
            search: null,

            // Includes media only uploaded to the specified post (ID)
            uploadedTo: null // wp.media.view.settings.post.id (for current post ID)
        },

        button: {
            text: 'Done'
        }

    }
    );
    return pubsMediaLibrary;
}

function openMediaUploader(inputname) {
    event.preventDefault();
    uploadInput = '';
    uploadInput = $('[name=' + inputname + ']');
    pubsMediaLibrary.open();
}