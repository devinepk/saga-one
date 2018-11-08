<template>

<div class="container">
    <div class="alert alert-dismissible fade show" :class="className">
        <button v-if="dismissable" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <slot></slot>
    </div>
</div>
</template>

<script>
module.exports = {
    props: {
        level: {
            type: String,
            required: false,
            default: 'info',
            validator: function (value) {
                // one of the Bootstrap theme colors
                return ['success', 'warning', 'danger', 'info', 'primary', 'secondary', 'light', 'dark'].indexOf(value) !== -1;
            }
        },
        dismissable: {
            type: Boolean,
            required: false,
            default: true
        }
    },

    computed: {
        className: function() {
            return 'alert-' + this.level;
        }
    }
}
</scripts>
