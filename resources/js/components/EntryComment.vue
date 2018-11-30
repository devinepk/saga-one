<template>
    <div class="comment p-2" @mouseover="showActions = true" @mouseout="showActions = false">

        <p class="mb-0 comment-author text-primary" :class="{ 'text-right': userIsAuthUser }">
            <font-awesome-icon v-if="!userIsAuthUser" icon="user" />
            <span class="font-weight-bold">{{ comment.user.name }}</span>
        </p>

        <div class="clearfix text-black-50">

            <p class="mb-0 comment-message" :class="{ 'float-right': userIsAuthUser }" v-html="comment.message"></p>

            <transition name="fade">
                <div v-if="userIsAuthUser && showActions" class="position-absolute">
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
            showActions: false
        };
    },

    computed: {
        userIsAuthUser() {
            return this.comment.user.id == this.$root.authUser.id;
        }
    },

    methods: {
        deleteComment() {
            let self = this;

            // Post to the app to delete the comment
            axios.post('/comment/' + self.comment.id + '/delete', { 'user': self.$root.authUser.id } )
                .then(function(response) {
                    console.log(response);
                    self.$parent.$parent.comments.splice(self.index, 1);
                })
                .catch(function(error) {
                    console.error(error.response);
                });
        },
        editComment() {

        },
        updateComment() {

        }
    }
}
</script>

<style>
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
