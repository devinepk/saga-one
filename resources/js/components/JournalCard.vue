<template>
<div class="card journal-card mb-5">
    <div class="card-header">


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

        <div v-if="showNextChange" class="cover-overlay align-items-end p-1 text-center">
            <span v-if="queue.length > 1">until <strong>{{ prettyNextChange }}</strong></span>
        </div>
        <span v-if="showBadgeCurrent"
            class="badge badge-current badge-secondary text-white rounded-circle p-3 shadow"
            data-toggle="tooltip" data-placement="top" title="You have this journal right now."
        >
            <font-awesome-icon size="4x" icon="book-reader" />
        </span>
    </div>

    <div v-if="writeUrl || readUrl || settingsUrl" class="row no-gutters" role="group" aria-label="Journal actions">
        <a v-if="writeUrl" :href="writeUrl" class="col btn btn-secondary" data-toggle="tooltip" data-placement="top" :title="writeTip">
            <font-awesome-icon icon="pencil-alt" />
        </a>
        <a v-if="readUrl" :href="readUrl" class="col btn btn-secondary" data-toggle="tooltip" data-placement="top" :title="readTip">
            <font-awesome-icon icon="book-reader"/>
        </a>
        <a v-if="settingsUrl" :href="settingsUrl" class="col btn btn-secondary border-0" data-toggle="tooltip" data-placement="top" title="Journal settings">
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
                <current-user-icon
                    v-if="user.id == journal.current_user.id"
                    :authCurrent="authUser.id == journal.current_user.id"
                    :currentUser="journal.current_user.name"
                    class="float-right mt-1"
                />

                <font-awesome-icon icon="user"></font-awesome-icon>

                <span class="ml-2">{{ user.name }}</span>


            </li>
        </ul>
    </template>

    <alert v-else class="mb-0" level="secondary" :dismissible="false">
        The real fun begins when you share this journal with others. <strong><a :href="settingsUrl" class="alert-link">Invite a friend</a> now!</strong>
    </alert>

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
        },
        showNextChange: {
            type: Boolean,
            default: true
        },
        bubble: {
            // Whether this card should bubble its journal info
            // up to the root Vue instance.
            type: Boolean,
            default: false
        }
    },

    created() {
        if (this.bubble) {
            // Send the journal info to the root Vue instance
            this.$root.journal = this.journal;
            Event.$emit('journalLoaded');
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
        },
        readTip: function() {
            return 'Read ' + this.journal.title;
        },
        writeTip: function() {
            return 'Write in ' + this.journal.title;
        },
        showBadgeCurrent: function() {
            return (this.useBadgeCurrent && this.journal.current_user && this.journal.current_user.id == this.authUser.id);
        },
        prettyNextChange: function() {
            return Moment(this.journal.next_change).format("MMM Do [at] h:mm a");
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
    top: 10px;
    right: 10px;
}
.journal-card-cover {
    height: 200px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: top center;
    position: relative;
}
.journal-card-cover > a {
    width: 100%;
    height:100%;
    display:block;
}
.journal-card-cover .cover-overlay {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(transparent 80%, black);
    color: white;
    display: flex;
    flex-wrap: wrap;
    font-variant: small-caps;
    letter-spacing: -0.5px;
}
</style>
