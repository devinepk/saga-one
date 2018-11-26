<template>
<li class="nav-item dropdown px-3">
    <a class="nav-link" id="notificationsLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
        <font-awesome-icon icon="bell"></font-awesome-icon>
        <span class="ml-2">Notifications</span>
        <span v-if="notifications.length" class="badge badge-light rounded ml-2 align-text-bottom">{{ notifications.length }}</span>
    </a>

    <div v-if="notifications.length" class="dropdown-menu dropdown-menu-right notification-item p-0" aria-labelledby="notificationsLabel">
        <notification-item
            v-for="(notification, index) in notifications"
            :key="notification.id"
            :index="index"
            :mark-as-read-url="markAsReadUrl(notification.id)" />
    </div>

    <div v-else class="dropdown-menu dropdown-menu-right notification-item p-0">
        <p class="mb-0 p-3 text-center font-italic">No new notifications</p>
    </div>
</li>
</template>

<script>
export default {
    props: {
        notificationsJson: {
            type: String,
            required: true
        },
        markAsReadUrlPattern: String,
        journalUrlPattern: String,
        replace: String
    },

    data() {
        return {
            notifications: {}
        };
    },

    mounted() {
        this.notifications = JSON.parse(this.notificationsJson);
    },

    methods: {
        markAsReadUrl(id) {
            return this.markAsReadUrlPattern.replace(this.replace, id);
        },
        journalUrl(id) {
            return this.journalUrlPattern.replace(this.replace, id);
        }
    }
}
</script>
