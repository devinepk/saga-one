<template>
<div id="entry-body" class="entry-body ql-editor p-3" v-html="body">
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

<style>
.entry-body {
    font-size: 1rem;
    line-height: 1.6;
    margin-top: 108px;
}
</style>
