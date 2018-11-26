<template>
<div v-if="!read" class="row no-gutters">
    <div class="col p-2">
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
                    return "<strong>" + data.user + "</strong> has accepted your invite to <strong><a href=\"" + this.$parent.journalUrl(data.journal_id) + "\">" + data.journal + "</strong>";
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
