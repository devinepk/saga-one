<template>
<div class="card journal-card border-0 mb-5">
    <div class="card-body">
        <h3 class="card-title">
            <a v-if="showUrl" :href="showUrl">{{ journal.title }}</a>
            <template v-else>{{ journal.title }}</template>
        </h3>

        <p v-if="journal.description" class="font-italic">{{ journal.description }}</p>


        <div class="mb-3 text-center">

            <a v-if="showUrl" :href="showUrl"><img :src="imageUrl" width="150" height="217"></a>
            <img v-else :src="imageUrl" width="150" height="217">

        </div>

    </div>

    <div class="row no-gutters" role="group" aria-label="Journal actions">
        <a :href="showUrl" class="col btn btn-secondary">
            <font-awesome-icon icon="pencil-alt"/>
            <span class="ml-2">Write</span>
        </a>
        <a :href="contentsUrl" class="col btn btn-secondary">
            <font-awesome-icon icon="book-reader"/>
            <span class="ml-2">Read</span>
        </a>
        <a :href="editUrl" class="col btn btn-secondary">
            <font-awesome-icon icon="cogs"></font-awesome-icon>
            <span class="ml-2">Settings</span>
        </a>
    </div>

    <template v-if="queue">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><h5 class="m-0">Queue:</h5></li>

            <li v-for="(user, index) in queue" :key="index" class="list-group-item list-group-item-action">

                <font-awesome-icon icon="user"></font-awesome-icon>
                <span class="ml-2">{{ user.name }}</span>

            </li>
        </ul>

        <div class="card-footer">
            <small v-if="authUser.id == journal.current_user.id">You've got this journal right now. What will you write?</small>
            <small v-else class="text-muted">{{ journal.current_user.name }} has this journal right now.</small>
        </div>

    </template>

    <div v-else class="card-footer">
        <small>The real magic begins when you share this journal with others. <a :href="editUrl">Invite a friend</a> now!</small>
    </div>

</div>
</template>

<script>
export default {
    props: {
        authUserJson: {
            type: String,
            required: true
        },
        showUrl: {
            type: String,
            required: false,
            default: ''
        },
        contentsUrl: {
            type: String,
            required: false,
            default: ''
        },
        imageUrl: {
            type: String,
            required: false,
            default: ''
        },
        editUrl: {
            type: String,
            required: false,
            default: ''
        },
        queueJson: {
            type: String,
            default: '{}'
        },
        journalJson: {
            type: String,
            default: '{}'
        }
    },

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        },
        queue: function() {
            return JSON.parse(this.queueJson);
        },
        journal: function() {
            return JSON.parse(this.journalJson);
        }
    }
}
</script>
