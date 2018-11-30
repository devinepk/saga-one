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
            class="badge badge-current badge-secondary text-white rounded-circle shadow"
            data-toggle="tooltip" data-placement="top" title="You have this journal right now."
        >
            <font-awesome-icon size="4x" icon="star" />
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

    <transition-group v-if="queue.length" name="flip-list" tag="ul" class="list-group list-group-flush">
        <li v-for="user in queue"
            :key="user.id"
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
    </transition-group>

    <alert v-else class="mb-0" level="secondary" :dismissible="false">
        The real fun begins when you share this journal with others. <strong><a :href="settingsUrl" class="alert-link">Invite a friend</a> now!</strong>
    </alert>

</div>
</template>

<script>
export default {
    props: {
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
        useBadgeCurrent: {
            type: Boolean,
            default: true
        },
        showNextChange: {
            type: Boolean,
            default: true
        },
        journalJson: {
            type: String,
            default: ''
        }
    },

    mounted() {
        let self = this;
        self.queue = JSON.parse(self.queueJson);

        Event.$on('queueUpdateSuccess', (newQ) => {
            // Rearrange the queue property to match the new queue
            let newQueue = [];

            // Start with the current user
            let currentUser = self.queue[0];
            newQueue.push(currentUser);

            // Loop through and update the queue
            let currentId = currentUser.id
            for (let i = 0; i < self.queue.length - 1; i++) {
                let nextId = newQ[currentId];
                // Find the user with the next id and add them to the new queue
                newQueue.push(self.queue.filter(user => user.id == nextId)[0]);
                currentId = nextId;
            }

            self.queue = newQueue;
        });
    },

    data() {
        return {
            queue: []
        };
    },

    computed: {
        journal: function() {
            // If a journal was passed to this card, use it.
            if (this.journalJson) {
                return JSON.parse(this.journalJson);
            }
            // Otherwise fall back to the journal stored in the root instance
            return this.$root.journal;
        },
        authUser: function() {
            return this.$root.authUser;
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
    height: 80px;
    width: 80px;
    padding-top: 18px;
}
.journal-card-cover {
    height: 300px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
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
