<template>
<div class="card mb-3">

    <div v-if="comments.length" class="card-body border-0 p-0">

        <entry-comment v-for="comment in comments" :key="comment.id" :comment="comment" />

    </div>

    <div class="card-footer p-0" :class="{ 'border-top-0': !comments.length }">
        <div class="position-relative">
            <transition name="fade">
                <span v-if="showFailure" class="badge badge-fail badge-danger rounded px-2 py-1">Failed to save!</span>
            </transition>

            <input type="text"
                v-model="newMessage"
                @keydown.enter.prevent="submitComment"
                id="message"
                name="message"
                class="form-control border-0"
                :placeholder="placeholder">
        </div>
    </div>

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
            comments: [],
            failure: false,
            failureText: ''
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
        },
        placeholder: function() {
            if (this.comments.length) {
                return "Write a comment...";
            }
            return "Be the first to write a comment about this...";
        },
        showFailure: function() {
            return this.failure && this.failureText == this.newMessage;
        }
    },

    methods: {
        submitComment() {
            let self = this;

            // Post to the app to save the new comment
            axios.post(self.postUrl + 'asdjkl', { message: self.newMessage } )
                .then(function(response) {
                    self.failure = false;
                    self.newMessage = self.failureText = '';
                    self.comments = response.data;
                    console.log(response);
                })
                .catch(function(error) {
                    self.failure = true;
                    self.failureText = self.newMessage;
                    console.error(error);
                });
        }
    }
}
</script>

<style>
.badge-fail {
    position: absolute;
    right: 10px;
    bottom: 10px;
}
</style>
