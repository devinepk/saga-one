<template>
<div class="comment p-2">
    <p class="mb-0 comment-author text-primary" :class="{ 'text-right': userIsAuthUser }">
        <font-awesome-icon v-if="!userIsAuthUser" icon="user" />
        <span class="font-weight-bold">{{ comment.user.name }}</span>
    </p>
    <div class="clearfix">
        <p class="mb-0 text-black-50 comment-message" :class="{ 'float-right': userIsAuthUser }" v-html="comment.message"></p>
    </div>
</div>
</template>

<script>
module.exports = {
    props: ['comment'],

    computed: {
        userIsAuthUser() {
            return this.comment.user.id == this.$root.authUser.id;
        }
    }
}
</script>

<style>
.comment-author {
    font-size: 0.75rem;
}
.comment-message {
    max-width: 75%;
}
</style>
