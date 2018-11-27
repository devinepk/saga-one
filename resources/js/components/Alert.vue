<template>
    <div class="alert" :class="classArray" role="alert">
        <button v-if="dismissible" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <font-awesome-icon v-if="level == 'danger'" :icon="levelIcon" />
        <slot></slot>
    </div>
</template>

<script>
module.exports = {
    props: {
        level: {
            type: String,
            required: false,
            default: 'primary',
            validator: function (value) {
                // one of the Bootstrap theme colors
                return ['success', 'warning', 'danger', 'info', 'primary', 'secondary', 'light', 'dark'].indexOf(value) !== -1;
            }
        },
        dismissible: {
            type: Boolean,
            required: false,
            default: true
        }
    },

    computed: {
        classArray: function() {
            $arr = ['alert-' + this.level];
            if (this.dismissible) {
                $arr.push('alert-dismissible', 'fade', 'show');
            }
            return $arr;
        },
        levelIcon: function() {
            return 'exclamation-triangle';
        }
    }
}
</scripts>

<style scoped>
p:last-child {
    margin-bottom:0;
}
</style>
