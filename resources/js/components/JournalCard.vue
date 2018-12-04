<template>
<div class="card journal-card mb-5">
    <div class="card-header">

        <h3 class="card-title mb-0">
            <a v-if="journal.action_urls.read" :href="journal.action_urls.read" class="journal-title" data-toggle="tooltip" data-placement="top" :title="readTip">{{ journal.title }}</a>
            <span v-else class="journal-title">{{ journal.title }}</span>

            <small v-if="!journal.active" class="badge badge-archived badge-dark rounded ml-2 p-2" data-toggle="tooltip" data-placement="top" title="You can read, but not write in, archived journals.">
                Archived
            </small>
        </h3>

        <p v-if="journal.description" class="font-italic mb-0">{{ journal.description }}</p>
    </div>

    <div class="journal-card-cover" :style="{'background-image': 'url(' + journal.action_urls.image + ')'}">

        <div v-if="showNextChange" class="cover-overlay align-items-end p-1 text-center">
            <span v-if="journal.next_change">rotates <strong>{{ journal.period_expression }}</strong></span>
        </div>
        <span v-if="showBadgeCurrent"
            class="badge badge-current badge-secondary text-white rounded-circle shadow"
            data-toggle="tooltip" data-placement="top" title="You have this journal right now.">
            <font-awesome-icon size="4x" icon="star" />
        </span>
    </div>

    <div v-if="showActionsBar" class="row no-gutters" role="group" aria-label="Journal actions">
        <a v-if="journal.action_urls.write" :href="journal.action_urls.write" class="col btn btn-secondary" data-toggle="tooltip" data-placement="top" :title="writeTip">
            <font-awesome-icon icon="pencil-alt" />
        </a>
        <a v-if="journal.action_urls.read" :href="journal.action_urls.read" class="col btn btn-secondary" data-toggle="tooltip" data-placement="top" :title="readTip">
            <font-awesome-icon :icon="['fab', 'readme']" />
        </a>
        <a v-if="journal.action_urls.settings" :href="journal.action_urls.settings" class="col btn btn-secondary border-0" data-toggle="tooltip" data-placement="top" title="Journal settings">
            <font-awesome-icon icon="cogs" />
        </a>
    </div>

    <transition-group v-if="journal.queue.length" name="flip-list" tag="ul" class="list-group list-group-flush">
        <li v-for="user in journal.queue"
            :key="user.id"
            class="list-group-item list-group-item-action"
            :class="{active: shouldHighlightUser(user)}"
        >
            <div class="row no-gutters">
                <div class="col-1">
                    <font-awesome-icon icon="user" />
                </div>
                <div class="col">
                    <p class="mb-0">{{ user.name }}</p>
                    <p v-if="shouldShowNextChange(user)" class="mb-0 next-change">until <strong>{{ prettyNextChange }}</strong></p>
                </div>
                <div class="col-1 text-right">
                    <current-user-icon
                        v-if="journalIsActive && isCurrentUser(user)"
                        :authCurrent="isAuthUser(user)"
                        :currentUser="journal.current_user.name"
                    />
                </div>
            </div>
        </li>

        <li v-if="journal.pending_invites.length" key="invites" class="list-group-item list-group-item-action">
            <font-awesome-icon icon="plus" />
            <span class="ml-2">{{ journal.pending_invites.length }} invited to join</span>
        </li>
    </transition-group>

    <alert v-if="showInviteMessage" class="mb-0" level="secondary" :dismissible="false">
        The real fun begins when you share this journal with others. <strong><a :href="journal.action_urls.settings" class="alert-link">Invite a friend</a> now!</strong>
    </alert>

</div>
</template>

<script>
export default {
    props: {
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

    computed: {
        journal: function() {
            // If a journal was passed to this card, use it.
            // Otherwise fall back to the journal stored in the root instance
            if (this.journalJson) {
                return JSON.parse(this.journalJson);
            } else {
                return this.$root.journal;
            }
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
            return (this.useBadgeCurrent
                    && this.journalIsActive
                    && this.isCurrentUser(this.authUser));
        },
        showInviteMessage: function() {
            return (this.journalIsActive
                    && this.journal.queue.length == 1
                    && this.isAuthUser(this.journal.creator)
                    && !this.journal.pending_invites.length);
        },
        showActionsBar: function() {
            return (this.journal.action_urls.write
                    || this.journal.action_urls.read
                    || this.journal.action_urls.settings);
        },
        prettyNextChange: function() {
            return Moment(this.journal.next_change).format("MMM Do [at] h:mma");
        },
        journalIsActive: function() {
            return (this.journal.active);
        }
    },

    methods: {
        isCurrentUser: function(user) {
            return (user.id == this.journal.current_user.id);
        },
        isAuthUser: function(user) {
            return (user.id == this.authUser.id);
        },
        shouldHighlightUser: function(user) {
            return (this.journalIsActive
                    && this.isCurrentUser(user)
                    && this.isAuthUser(user)
                    && this.journal.queue.length > 1);
        },
        shouldShowNextChange: function(user) {
            return (this.journalIsActive
                    && this.isCurrentUser(user)
                    && this.journal.next_change);
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
.next-change {
    font-size: 0.8rem;
}
</style>
