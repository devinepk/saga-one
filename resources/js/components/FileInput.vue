<template>
    <div class="row no-gutters">
        <div class="col custom-file" :class="{ uploaded: uploaded }">
            <input type="file" @change="handleUpload" ref="fileInput" class="custom-file-input" :class="{ 'is-invalid': errors.cover_image }" :name="name" :id="id">
            <label class="custom-file-label" :for="id" :class="[ uploaded ? '' : 'text-muted font-weight-normal' ]">
                <span>{{ placeholder }}</span>
                <font-awesome-icon v-if="uploaded" icon="check-circle" class="text-primary ml-1" />
            </label>
            <span v-if="errors.cover_image" class="invalid-feedback" role="alert">
                <strong>{{ errors.cover_image[0] }}</strong>
            </span>
        </div>
        <button v-if="uploaded" @click="removeUpload" type="button" class="btn btn-danger font-weight-bold align-bottom remove-file">&times;</button>
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
        },
        removeUpload() {
            let self = this;

            // This is tricky. We're going to wrap the input in a form element,
            // reset that form, and then immediately unwrap it.
            let input = $('#' + self.id);
            input.wrap('<form>').closest('form').get(0).reset();
            input.unwrap();

            self.uploaded = false;
            self.placeholder = self.initialPlaceholder;
        }
    }
}
</script>

<style>
.remove-file {
    width: 40px;
}
</style>
