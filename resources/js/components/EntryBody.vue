<template>
<div id="entry-body" class="entry-body p-2" v-html="body">
</div>
</template>

<script>
module.exports = {
    props: ['body', 'comments'],

    data: function() {
        return {
            elements: []
        }
    },

    methods: {
        findElements: function() {
        }
    }
}
</script>
