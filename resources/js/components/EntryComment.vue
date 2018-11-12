<template>
<div class="comment text-black-50 p-2">
    <p class="m-0">
        <font-awesome-icon icon="user" />
        <span class="font-weight-bold">{{ author }}</span>
    </p>
    <p class="m-0 comment-message">
        <slot></slot>
    </p>
</div>
</template>

<script>
module.exports = {
    props: ['author']
}
</script>

<style>
.comment-message {
    font-size: 0.75rem;
}
</style>
