<template>
    <div class="custom-file">
        <input type="file" @change="handleUpload" ref="fileInput" class="custom-file-input" :class="{ 'is-invalid': errors.cover_image }" :name="name" :id="id">
        <label class="custom-file-label" :for="id" :class="[ uploaded ? '' : 'text-muted font-weight-normal' ]">
            {{ placeholder }}
            <font-awesome-icon v-if="uploaded" icon="check-circle" class="text-primary ml-1" />
        </label>
        <span v-if="errors.cover_image" class="invalid-feedback" role="alert">
            <strong>{{ $errors.cover_image }}</strong>
        </span>
    </div>
</template>

<script>
export default {
    props: {
        errorsJson: {
            type: String,
            default: '{}'
        },
        name: {
            type: String,
            required: true
        },
        id: {
            type: String,
            required: true
        },
        initialPlaceholder: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            placeholder: '',
            uploaded: false
        };
    },

    mounted() {
        this.placeholder = this.initialPlaceholder;
    },

    computed: {
        errors() {
            return JSON.parse(this.errorsJson);
        }
    },

    methods: {
        handleUpload() {
            let file = this.$refs.fileInput.files[0];
            this.placeholder = file.name;
            this.uploaded = true;
            console.log(this.$refs.fileInput.files);
        }
    }
}
</script>
