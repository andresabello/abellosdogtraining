jQuery(($) => {
    $('.pi-upload-image').on('click', '', function (e) {
        e.preventDefault()
        let button = $(this)

        let custom_uploader = wp.media({
            title: 'Insert image',
            library: {
                type: 'image',
            },
            button: {
                text: 'Use this image',
            },
            multiple: false,
        }).on('select', () => {

            let attachment = custom_uploader.state().
                get('selection').
                first().
                toJSON()

            button.closest('.upload').
                find('.preview-upload').
                attr('src', attachment.url).
                addClass('true_pre_image')

            // button.closest('.upload').
            //     find('.text-upload').
            //     val(attachment.url)

            button.closest('.upload').find('.text-upload-value').val(attachment.id)
        }).open()
    })

    $('.pi-remove-image').on('click', (e) => {
        e.preventDefault()
        $(this).
            hide().
            prev().
            val('').
            prev().
            addClass('button').
            html('Upload image')
        return false
    })

    $('.pi-color-picker').wpColorPicker();
})