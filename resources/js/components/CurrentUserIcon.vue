<template>
    <font-awesome-icon
        icon="book-reader"
        data-toggle="tooltip" data-placement="top" :title="queueTip"
    />
</template>

<script>
export default {
    props: {
        authCurrent: {
            type: Boolean,
            required: true
        },
        currentUser: {
            type: String,
            required: true
        }
    },

    computed: {
        queueTip: function() {
            if (this.authCurrent) {
                return "You have this journal right now."
            }
            return this.currentUser + " has this journal right now."
        }
    }
}
</script>
