<template>
<div id="comments" class="card mb-3">

    <transition-group v-if="comments.length" name="list" tag="div" class="card-body border-0 p-0">
        <entry-comment v-for="(comment, index) in comments" :key="comment.id" :comment="comment" :index="index" />
    </transition-group>

    <div class="card-footer p-0" :class="{ 'border-top-0': !comments.length }">
        <div class="position-relative">
            <transition name="fade">
                <span v-if="showFailure" class="badge badge-fail badge-danger rounded px-2 py-1">Failed to save!</span>
            </transition>

            <textarea
                v-model="newMessage"
                @keydown.enter.prevent="submitComment"
                id="add-message"
                name="message"
                ref="message"
                class="form-control border-0"
                :placeholder="placeholder"
                rows="1"
            ></textarea>
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
            return "Be the first to write a comment...";
        },
        showFailure: function() {
            return this.failure && this.failureText == this.newMessage;
        }
    },

    methods: {
        submitComment() {
            let self = this;

            // Don't post empty messages
            if (self.newMessage == '') return;

            // Post to the app to save the new comment
            axios.post(self.postUrl, { message: self.newMessage } )
                .then(function(response) {
                    self.failure = false;
                    self.newMessage = self.failureText = '';
                    self.comments = response.data;

                    // If the comment input is at the bottom of the page, then
                    // wait for DOM to update, then scroll down
                    if (self.scrollIsNeeded()) {
                        setTimeout(() => {
                            self.$refs.message.scrollIntoView(false);
                        }, 100);
                    }
                })
                .catch(function(error) {
                    self.failure = true;
                    self.failureText = self.newMessage;
                    console.error(error.response);
                });
        },

        scrollIsNeeded() {
            let rect = this.$refs.message.getBoundingClientRect();
            return (window.innerHeight - rect.top < 100);
        }
    }
}
</script>

<style scoped>
#add-message {
    resize: none;
}
.badge-fail {
    position: absolute;
    right: 10px;
    bottom: 10px;
}
</style>
