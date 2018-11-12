<template>
    <div id="entry-body" class="entry-body ql-editor p-3" v-html="body"></div>
</template>

<script>
module.exports = {
    props: ['body', 'comments'],
}
</script>

<style>
.entry-body {
    font-size: 1rem;
    line-height: 1.6;
}
</style>
