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
            editor: null
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

        this.editor.root.innerHTML = this.value;

        this.editor.on('text-change', () => this.update());
    },

    methods: {
        update() {
            Event.$emit('quill-input', this.editor.getText() ? this.editor.root.innerHTML : '');
        }
    }
}
</script>

<style>
svg {
    vertical-align: baseline;
}
</style>
