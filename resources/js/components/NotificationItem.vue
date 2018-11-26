<template>

    <div v-if="!read" class="card border-bottom-0">
        <div class="card-header">
            <span class="close" @click="markAsRead">&times;</span>
            <transition name="fade">
                <span v-if="error" class="float-right badge badge-danger rounded px-2 py-1 mr-1 mt-1">Failed to dismiss!</span>
            </transition>
            <h5 class="mb-0" v-html="header"></h5>
        </div>
        <div class="card-body">
            <p class="mb-0" v-html="message"></p>
        </div>
    </div>

</template>

<script>
export default {
    props: {
        markAsReadUrl: {
            type: String,
            required: true
        },
        index: Number
    },

    data() {
        return {
            read: false,
            error: false,
            // Since this item is inside a transition-group, the menu is the
            // grandparent of this item.
            menu: this.$parent.$parent
        };
    },

    computed: {
        notification() {
            return this.$parent.$parent.notifications[this.index];
        },

        message() {
            let data = this.notification.data;

            switch (this.notification.type) {
                case "App\\Notifications\\InviteAccepted":
                    return '<strong>' + data.user + '</strong> has <span class="text-primary font-weight-bold">accepted</span> your invite to <strong><a href="' + this.menu.journalSettingsUrl(data.journal_id) + '">' + data.journal + '</a></strong>.';

                case "App\\Notifications\\InviteDeclined":
                    return '<strong>' + data.user + '</strong> has <span class="text-danger font-weight-bold">declined</span> your invite to <strong><a href="' + this.menu.journalSettingsUrl(data.journal_id) + '">' + data.journal + '</a></strong>.';

                case "App\\Notifications\\JournalRotatedToUser":
                    return 'You have this journal until ' + data.next_change + '.';
            }
        },

        header() {
            switch (this.notification.type) {
                case "App\\Notifications\\InviteAccepted":
                    return 'Invite Accepted';

                case "App\\Notifications\\InviteDeclined":
                    return 'Invite Declined';

                case "App\\Notifications\\JournalRotatedToUser":
                    return 'It\'s your turn to write in <strong><a href="' + this.menu.journalWriteUrl(this.notification.notifiable_id) + '">' + this.notification.data.journal + '</a></strong>!</h5>';
            }
        }
    },

    methods: {
        markAsRead() {
            // Send an axios request to NotificationController::markAsRead()
            let self = this;
            self.error = false;

            axios.post(self.markAsReadUrl)
                .then(function (response) {
                    if (response.data.read_at) {
                        self.menu.notifications.splice(self.index, 1);
                    } else {
                        self.error = true;
                    }
                })
                .catch(function (error) {
                    self.error = true;
                });
        }
    }
}
</script>

<style scoped>
.badge-fail {
    position: absolute;
    right: 10px;
    bottom: 10px;
}
</style>
