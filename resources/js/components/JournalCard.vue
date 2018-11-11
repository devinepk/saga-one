<template>
<div class="card journal-card mb-5">
    <div class="card-header">
        <span v-if="showBadgeCurrent"
            class="badge badge-current badge-secondary text-white rounded-circle p-3 shadow"
            data-toggle="tooltip" data-placement="top" title="You have this journal right now."
        >
            <font-awesome-icon size="4x" icon="book-reader" />
        </span>

        <h3 class="card-title mb-0">
            <a v-if="readUrl" :href="readUrl" data-toggle="tooltip" data-placement="top" :title="readTip">{{ journal.title }}</a>
            <template v-else>{{ journal.title }}</template>

            <small v-if="!journal.active" class="badge badge-archived badge-dark rounded ml-2 p-2" data-toggle="tooltip" data-placement="top" title="You can read, but not write in, archived journals.">
                Archived
            </small>
        </h3>

        <p v-if="journal.description" class="font-italic mb-0">{{ journal.description }}</p>
    </div>

    <div class="journal-card-cover" :style="{'background-image': 'url(' + imageUrl + ')'}">
        <a v-if="writeUrl" :href="writeUrl"></a>
        <a v-else-if="readUrl" :href="readUrl"></a>
    </div>

    <div v-if="writeUrl || readUrl || settingsUrl" class="row no-gutters" role="group" aria-label="Journal actions">
        <a v-if="writeUrl" :href="writeUrl" class="col btn btn-secondary" data-toggle="tooltip" data-placement="top" :title="writeTip">
            <font-awesome-icon icon="pencil-alt" />
        </a>
        <a v-if="readUrl" :href="readUrl" class="col btn btn-secondary" data-toggle="tooltip" data-placement="top" :title="readTip">
            <font-awesome-icon icon="book-reader"/>
        </a>
        <a v-if="settingsUrl" :href="settingsUrl" class="col btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Journal settings">
            <font-awesome-icon icon="cogs" />
        </a>
    </div>

    <template v-if="queue.length">
        <ul class="list-group list-group-flush">
            <li v-for="(user, index) in queue"
                :key="index"
                class="list-group-item list-group-item-action"
                :class="{active: user.id == authUser.id && authUser.id == journal.current_user.id}"
            >

                <font-awesome-icon icon="user"></font-awesome-icon>

                <span class="ml-2">{{ user.name }}</span>

                <font-awesome-icon
                    v-if="user.id == journal.current_user.id"
                    icon="book-reader"
                    class="float-right mt-1"
                    data-toggle="tooltip" data-placement="top" :title="queueTip(user.id, user.name)"
                />

            </li>
        </ul>
    </template>

    <div v-else class="alert alert-secondary mb-0">
            The real fun begins when you share this journal with others. <strong><a :href="settingsUrl">Invite a friend</a> now!</strong>
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
        writeUrl: {
            type: String,
            required: false,
            default: ''
        },
        readUrl: {
            type: String,
            required: false,
            default: ''
        },
        imageUrl: {
            type: String,
            required: false,
            default: ''
        },
        settingsUrl: {
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
        },
        useBadgeCurrent: {
            type: Boolean,
            default: true
        }
    },

    mounted() {
        $('[data-toggle="tooltip"]').tooltip();
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
        },
        readTip: function() {
            return 'Read ' + this.journal.title;
        },
        writeTip: function() {
            return 'Write in ' + this.journal.title;
        },
        showBadgeCurrent: function() {
            return (this.useBadgeCurrent && this.journal.current_user.id == this.authUser.id);
        }
    },

    methods: {
        queueTip: function(id, name) {
            if (id == this.authUser.id) {
                return "You have this journal right now."
            }
            return name + " has this journal right now."
        }
    }
}
</script>

<style>
.badge-archived {
    font-size: 0.5rem;
    vertical-align: middle;
}
.badge-current {
    position: absolute;
    top: -10px;
    right: 10px;
}
</style>
