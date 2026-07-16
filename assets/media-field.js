class NWMediaField {

    constructor(element) {
        this.wrapper = element;
        this.button = element.querySelector('.nw-media-select');
        this.input = element.querySelector('.nw-media-input');
        this.preview = element.querySelector('.nw-media-preview');

        this.frame = null;

        // Bail if no button is found
        if (!this.button) return;

        this.bindEvents();
    }


    bindEvents() {

        this.button.addEventListener('click', (event) => {
            event.preventDefault();

            this.openMediaLibrary();
        });

    }


    openMediaLibrary() {

        const multiple = this.button.dataset.multiple === 'true';

        this.frame = wp.media({
            title: 'Select Media',
            multiple,
            library: {
                type: 'image'
            },
            button: {
                text: 'Use Media'
            }
        });


        this.frame.on('select', () => {

            const selection = this.frame
                .state()
                .get('selection');

            const ids = [];

            this.preview.innerHTML = '';

            selection.each((attachment) => {

                ids.push(attachment.id);

                this.renderPreview(
                    attachment.attributes.url
                );

            });

            this.input.value = ids.join(',');

        });


        this.frame.open();

    }


    renderPreview(url) {

        const image = document.createElement('img');

        image.src = url;
        image.width = 100;

        this.preview.appendChild(image);

    }

}


document.addEventListener('DOMContentLoaded', () => {

    document
        .querySelectorAll('.nw-media-field')
        .forEach((field) => {
            new NWMediaField(field);
        });

});