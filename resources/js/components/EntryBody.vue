<template>
<div id="entry-body" class="entry-body p-3" v-html="body">
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
