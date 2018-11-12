<template>
<div class="card mb-3">

    <div class="card-body border-0 p-0">

        <entry-comment v-for="comment in comments" :key="comment.id" :author="comment.author">
            {{ comment.message }}
        </entry-comment>

        <div v-if="!comments.length" class="text-muted p-1">
            Be the first to post a comment...
        </div>
    </div>

    <form class="card-footer p-0" ref="postForm" method="post" :action="postUrl">
        <slot name="csrf"></slot>
        <input type="text" @keydown.enter="submitPostForm" id="message" name="message" class="form-control border-0" placeholder="Write a comment...">
    </form>

</div>
</template>

<script>
export default {
    props: {
        commentsJson: {
            type: String,
            default: '{}'
        },
        postUrl: {
            type: String,
            required: true
        }
    },

    computed: {
        comments: function() {
            return JSON.parse(this.commentsJson);
        }
    },

    methods: {
        submitPostForm() {
            this.$refs.postForm.submit();
        }
    }
}
</script>
