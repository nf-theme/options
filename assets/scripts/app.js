import Sortable from 'sortablejs';

(function($) {
    let IMAGE_UPLOAD_BTN_CLASSNAME = 'nto-image-upload-btn';
    let IMAGE_REMOVE_ITEM_CLASSNAME = 'nto-image-remove';
    let GALLERY_UPLOAD_BTN_CLASSNAME = 'nto-gallery-upload-btn';
    let GALLERY_SORTABLE_CLASSNAME = 'nto-items';
    let GALLERY_REMOVE_ITEM_CLASSNAME = 'nto-gallery-remove';

    $(document).on('click', `.${IMAGE_UPLOAD_BTN_CLASSNAME}`, function(event) {
        var input = $(event.target);
        var url;
        var uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        uploader.on('select', function() {
            uploader.state().get('selection').models.forEach(function(item) {
                let attachment = item.toJSON();
                input.parent().parent().find('.card-img-top').attr('src', attachment.url);
                input.parent().parent().find(`[name="${input.attr('data-input')}"]`).val(attachment.url);
            });
        });
        uploader.open();
        return false;
    });

    $(document).on('click', `.${GALLERY_UPLOAD_BTN_CLASSNAME}`, function(event) {
        var input = $(event.target);
        var url;
        var uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
        uploader.on('select', function() {
            input.parent().parent().find('.nto-gallery-item').remove();
            let defaultImg = input.parent().parent().find('.nto-items').attr('data-img');
            let items = [];
            uploader.state().get('selection').models.forEach(function(item) {
                let attachment = item.toJSON();
                items.push({
                    url: attachment.url,
                });
                let img = document.createElement('li');
                img.className = 'nto-gallery-item';
                img.innerHTML = `<img src="${defaultImg}" style="background-image: url('${attachment.url}')" data-src="${attachment.url}">`;
                input.parent().parent().find('.nto-items').append(img);
                input.parent().parent().find('input').val(JSON.stringify(items));
            });
        });
        uploader.open();
        return false;
    });

    $(document).on('click', `.${IMAGE_REMOVE_ITEM_CLASSNAME}`, remove);
    $(document).on('click', `.${GALLERY_REMOVE_ITEM_CLASSNAME}`, remove);

    function remove(event) {
        var input = $(event.target);
        let cf = confirm('Are you sure you want to delete all items');
        if (cf !== false) {
            var url = new URL(document.location.href);
            var tab = url.searchParams.get('tab');
            var data = {
                'action': 'nto_remove',
                'field': input.attr('data-input'),
                'page': tab
            };
            $.post(ajaxurl, data, function(response) {
                document.location.href = response.redirect_url;
            });
        }
        return false;
    };

    $(`.${GALLERY_SORTABLE_CLASSNAME}`).each(function(key, item) {
        var gallery_sortable = new Sortable(item, {
            animation: 150,
            onUpdate: function(evt) {
                let items = [];
                $(evt.srcElement).find('.nto-gallery-item').each(function(k, i) {
                    items.push({
                        url: $(i).find('img').attr('data-src'),
                    });
                    $(evt.srcElement).parent().find('input').val(JSON.stringify(items))
                });
            }
        });
    });
})(jQuery)
