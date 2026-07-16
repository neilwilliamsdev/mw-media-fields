class NWMediaField {

    constructor(element) {

        this.wrapper = element;
        this.button = element.querySelector('.nw-media-select');
        this.input = element.querySelector('.nw-media-input');
        this.preview = element.querySelector('.nw-media-preview');

        this.frame = null;

        if (!this.button) return;

        this.bindEvents();

        this.loadExistingPreview();

    }


    bindEvents() {

        this.button.addEventListener('click', (event) => {

            event.preventDefault();

            this.openMediaLibrary();

        });

    }


    openMediaLibrary() {

        const multiple = this.button.dataset.multiple === 'true';

        const currentIds = this.input.value
            ? JSON.parse(this.input.value)
            : [];


        this.frame = wp.media({

            title: 'Select Media',

            // Allow multiple selection if the button has the data-multiple attribute set to true
            multiple: multiple ? 'add' : false,

            library: {
                type: 'image'
            },

            button: {
                text: 'Use Media'
            }

        });


        this.frame.on('open', () => {

            const selection = this.frame
                .state()
                .get('selection');


            currentIds.forEach((id) => {

                const attachment = wp.media.attachment(id);

                selection.add(attachment);

            });

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
                    attachment.id,
                    attachment.attributes.url
                );

            });


            this.input.value = JSON.stringify(ids);

        });


        this.frame.open();

    }

    loadExistingPreview() {

        const ids = this.input.value
            ? JSON.parse(this.input.value)
            : [];


        ids.forEach((id) => {

            const attachment = wp.media.attachment(id);

            attachment.fetch().then(() => {

                this.renderPreview(
                    id,
                    attachment.attributes.url
                );

            });

        });

    }

    renderPreview(id, url) {

        const wrapper = document.createElement('div');

        wrapper.classList.add('nw-media-preview-item');

        wrapper.dataset.id = id;


        const image = document.createElement('img');

        image.src = url;
        image.width = 100;


        const remove = document.createElement('button');

        remove.type = 'button';
        remove.innerHTML = '&times;';
        remove.classList.add('nw-media-remove');


        remove.addEventListener('click', () => {

            wrapper.remove();

            this.removeImage(id);

        });


        wrapper.appendChild(image);
        wrapper.appendChild(remove);


        this.preview.appendChild(wrapper);

    }

    removeImage(id) {

        const ids = this.input.value
            ? JSON.parse(this.input.value)
            : [];


        const updatedIds = ids.filter((imageId) => {

            return imageId !== id;

        });


        this.input.value = JSON.stringify(updatedIds);

    }

}


document.addEventListener('DOMContentLoaded', () => {

    document
        .querySelectorAll('.nw-media-field')
        .forEach((field) => {

            new NWMediaField(field);

        });

});