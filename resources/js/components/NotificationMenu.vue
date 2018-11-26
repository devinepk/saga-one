<template>

    <li class="nav-item px-3 position-relative">

        <a class="nav-link" id="notificationsLabel" @click="toggleItems" href="#">
            <font-awesome-icon icon="bell"></font-awesome-icon>
            <span class="ml-2">Notifications</span>
            <span v-if="notifications.length" class="badge badge-light rounded ml-2 align-text-bottom">{{ notifications.length }}</span>
        </a>

        <transition name="fade">
            <div v-if="showItems" class="p-0 text-body bg-white shadow notification-menu">
                <div v-for="(notification, index) in notifications" :key="notification.id">
                    <notification-item
                        :index="index"
                        :mark-as-read-url="markAsReadUrl(notification.id)" />
                    <div v-if="index != notifications.length - 1" class="dropdown-divider m-0"></div>
                </div>

                <p v-if="!notifications.length" class="mb-0 p-3 text-center font-italic">No new notifications</p>
            </div>
        </transition>

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
        journalSettingsUrlPattern: String,
        journalWriteUrlPattern: String,
        replace: String
    },

    data() {
        return {
            notifications: {},
            showItems: false
        };
    },

    mounted() {
        this.notifications = JSON.parse(this.notificationsJson);
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
        toggleItems() {
            this.showItems = !this.showItems;
        }
    }
}
</script>
