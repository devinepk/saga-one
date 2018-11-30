<template>
    <div class="comment p-2" @mouseover="showActions = true" @mouseout="showActions = false">

        <p class="mb-0 comment-author text-primary" :class="{ 'text-right': userIsAuthUser }">
            <font-awesome-icon v-if="!userIsAuthUser" icon="user" />
            <span class="font-weight-bold">{{ comment.user.name }}</span>
        </p>

        <div class="clearfix text-black-50">

            <div class="comment-message" :class="{ 'float-right': userIsAuthUser }">

                <transition name="fade">
                    <div v-if="failure" class="text-right">
                        <span class="badge badge-fail badge-danger rounded px-2 py-1">Error</span>
                    </div>
                </transition>

                <textarea v-if="userIsAuthUser && editMode"
                    class="form-control"
                    v-model="editMessage"
                    @keydown.enter.prevent="updateComment"
                    id="message"
                    name="message">
                </textarea>

                <p v-else class="mb-0">{{ displayMessage }}</p>

            </div>

            <transition name="fade">
                <div v-if="userIsAuthUser && showActions && isNew" class="position-absolute">
                    <button @click="deleteComment" class="btn btn-link p-0" data-toggle="tooltip" data-placement="top" title="Delete comment">
                        <font-awesome-icon size="sm" icon="trash-alt" />
                    </button>
                    <button @click="editComment" class="btn btn-link p-0" data-toggle="tooltip" data-placement="top" title="Edit comment">
                        <font-awesome-icon size="sm" icon="pencil-alt" />
                    </button>
                </div>
            </transition>

        </div>
    </div>
</template>

<script>
module.exports = {
    props: {
        comment: {
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },

    data() {
        return {
            showActions: false,
            editMode: false,
            failure: false,
            displayMessage: '',
            editMessage: ''
        };
    },

    mounted() {
        this.editMessage = this.displayMessage = this.comment.message;
    },

    computed: {
        userIsAuthUser() {
            return this.comment.user.id == this.$root.authUser.id;
        },
        isNew() {
            return (this.comment.created_at > this.$root.journal.last_change);
        }
    },

    methods: {
        deleteComment() {
            let self = this;

            // Post to the app to delete the comment
            axios.post('/comment/' + self.comment.id + '/delete', { user: self.$root.authUser.id } )
                .then(function(response) {
                    self.$parent.$parent.comments.splice(self.index, 1);
                })
                .catch(function(error) {
                    console.error(error.response);
                    self.failure = true;
                    setTimeout(() => self.failure = false, 1000);
                });
        },
        editComment() {
            this.editMode = !this.editMode;
        },
        updateComment() {
            let self = this;

            let post = {
                user: self.$root.authUser.id,
                message: self.editMessage
            };

            // Post to the app to update the comment
            axios.post('/comment/' + self.comment.id + '/update', post)
                .then(function(response) {
                    self.displayMessage = self.editMessage;
                    self.editMode = false;
                })
                .catch(function(error) {
                    console.error(error.response);
                    self.editMessage = self.comment.message;
                    self.editMode = false;
                    self.failure = true;
                    setTimeout(() => self.failure = false, 1000);
                });
        }
    }
}
</script>

<style scoped>
#message {
    resize: none;
}
.comment {
    transition: 0.2s;
}
.comment:hover{
    background-color: #eee;
}
.comment-author {
    font-size: 0.75rem;
}
.comment-message {
    max-width: 75%;
}
</style>
