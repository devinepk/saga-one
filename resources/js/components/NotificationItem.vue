<template>
<div v-if="!read" class="row no-gutters">
    <div class="col p-3">
        <p class="mb-0" v-html="message"></p>
    </div>
    <a href="#" @click.prevent="markAsRead" class="col-2 d-flex justify-content-center align-items-center">
        <font-awesome-icon
            icon="check-square"
            size="2x"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Mark as read"
        />
    </a>
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
            error: false
        };
    },

    computed: {
        notification() {
            return this.$parent.notifications[this.index];
        },

        message() {
            let data = this.notification.data;

            switch (this.notification.type) {
                case "App\\Notifications\\InviteAccepted":
                    return '<strong>' + data.user + '</strong> has <span class="text-dark font-weight-bold">accepted</span> your invite to <strong><a href="' + this.$parent.journalSettingsUrl(data.journal_id) + '">' + data.journal + '</a></strong>';

                case "App\\Notifications\\InviteDeclined":
                    return '<strong>' + data.user + '</strong> has <span class="text-danger font-weight-bold">declined</span> your invite to <strong><a href="' + this.$parent.journalSettingsUrl(data.journal_id) + '">' + data.journal + '</a></strong>';

                case "App\\Notifications\\JournalRotatedToUser":
                    return 'It\'s your turn to write in <strong><a href="' + this.$parent.journalWriteUrl(this.notification.notifiable_id) + '">' + data.journal + '</a></strong>! You have this journal until ' + data.next_change + '.';
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
                        self.$parent.notifications.splice(self.index, 1);
                    } else {
                        self.error = true;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    self.error = true;
                });
        }
    }
}
</script>
