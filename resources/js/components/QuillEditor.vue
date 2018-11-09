<template>
    <div ref="editor" id="editor" v-html="value"></div>
</template>

<script>
import Quill from 'quill';

export default {
    props: {
        value: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            editor: null,
            headerExpanded: false,
            selectedHeader: false
        };
    },

    mounted() {
        this.editor = new Quill(this.$refs.editor, {
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    ['blockquote'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['clean']
                ]

            },
            theme: 'snow',
            formats: [
                'bold', 'underline', 'header', 'italic',
                'strike', 'color', 'background', 'blockquote', 'list',
                'script', 'indent', 'align'
            ]
        });

        // Activate tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Display input passed in as a prop
        this.editor.root.innerHTML = this.value;

        // Listen for Quill's built-in text-change event
        this.editor.on('text-change', () => this.update());
    },

    methods: {
        update: function() {
            // Propogate event to the global event bus
            Event.$emit('quill-input', this.editor.getText() ? this.editor.root.innerHTML : '');
        },

        toggleHeader: function() {
            this.headerExpanded = !this.headerExpanded;
        },

        selectHeader: function(header) {
            this.selectedHeader = header;
        }
    }
}
</script>

<style>
svg {
    vertical-align: baseline;
}
</style>
