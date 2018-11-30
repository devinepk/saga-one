<template>

    <li class="nav-item px-3 dropdown">

        <a class="nav-link" id="notificationsLabel" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <font-awesome-icon icon="bell"></font-awesome-icon>
            <span class="ml-2">Notifications</span>
            <span v-if="notifications.length" class="badge badge-light rounded ml-2 align-text-bottom">{{ notifications.length }}</span>
        </a>

        <div class="p-0 text-body bg-white shadow dropdown-menu dropdown-menu-right notifications-dropdown" aria-labelledby="notificationsLabel">

            <transition-group name="fade" tag="div">
                <notification-item
                    v-for="(notification, index) in notifications"
                    :key="notification.id"
                    :index="index"
                    :mark-as-read-url="markAsReadUrl(notification.id)" />
            </transition-group>

            <p v-if="!notifications.length" class="mb-0 p-3 text-center font-italic">No new notifications</p>
        </div>

    </li>
</template>

<script>
export default {
    props: {
        authUserJson: {
            type: String,
            required: true
        },
        journalJson: {
            type: String,
            default: '{}'
        },
        notificationsJson: {
            type: String,
            required: true
        },
        markAsReadUrlPattern: String,
        journalSettingsUrlPattern: String,
        journalWriteUrlPattern: String,
        inviteUrlPattern: String,
        replace: String
    },

    data() {
        return {
            notifications: {},
            showItems: false
        };
    },

    created() {
        // Send the journal info to the root Vue instance
        this.$root.journal = this.journal;
        Event.$emit('journalLoaded');
        // Send the auth user info to the root Vue instance
        this.$root.authUser = this.authUser;
    },

    mounted() {
        this.notifications = JSON.parse(this.notificationsJson);

        Echo.private('App.User.' + this.authUser.id)
            .listen('UserInvited', (e) => {
                console.log(e);
            });
    },

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        },
        journal: function() {
            return JSON.parse(this.journalJson);
        },
    },

    methods: {
        markAsReadUrl(id) {
            return this.markAsReadUrlPattern.replace(this.replace, id);
        },
        journalSettingsUrl(id) {
            return this.journalSettingsUrlPattern.replace(this.replace, id);
        },
        journalWriteUrl(id) {
            return this.journalWriteUrlPattern.replace(this.replace, id);
        },
        inviteUrl(id) {
            return this.inviteUrlPattern.replace(this.replace, id);
        },
        toggleItems() {
            this.showItems = !this.showItems;
        },
        closeWindow() {
            this.showItems = false;
        }
    }
}
</script>
