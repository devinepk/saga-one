<template>
<div class="card mb-3">

    <div class="card-body border-0 p-0">

        <entry-comment v-for="comment in comments" :key="comment.id" :comment="comment">
        </entry-comment>

        <div v-if="!comments.length" class="text-muted p-1">
            <span class="ml-1">Be the first to post a comment on this entry...</span>
        </div>
    </div>

    <form class="card-footer p-0">
        <input type="text"
            v-model="newMessage"
            @keydown.enter.prevent ="submitPostForm"
            id="message"
            name="message"
            class="form-control border-0"
            placeholder="Write a comment...">
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
        },
        authUserJson: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            newMessage: '',
            comments: []
        };
    },

    mounted() {
        let self = this;

        self.comments = JSON.parse(self.commentsJson);
        self.$on('updateCommentSuccess', (data) => {
            self.comments = JSON.parse(data);
        });
    },

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        }
    },

    methods: {
        submitPostForm() {
            let self = this;

            // Post to the app to save the new comment
            axios.post(self.postUrl, { message: self.newMessage } )
                .then(function(response) {
                    self.comments = response.data;
                    self.newMessage = '';
                    console.log(response);
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    }
}
</script>
