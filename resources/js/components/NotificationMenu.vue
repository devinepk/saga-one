<template>

    <li class="nav-item px-3 position-relative">

        <a class="nav-link" id="notificationsLabel" @click="toggleItems" href="#">
            <font-awesome-icon icon="bell"></font-awesome-icon>
            <span class="ml-2">Notifications</span>
            <span v-if="notifications.length" class="badge badge-light rounded ml-2 align-text-bottom">{{ notifications.length }}</span>
        </a>

        <transition name="fade">
            <div v-if="showItems" class="p-0 text-body bg-white shadow notification-menu border-bottom">
                <div class="bg-primary text-right pr-2">
                    <small>
                        <template v-if="notifications.length">
                            <a class="text-light" href="#">Dismiss all</a>
                            <span class="px-2">|</span>
                        </template>
                        <a class="text-light" href="#" @click="closeWindow">Close</a>
                    </small>
                </div>

                <transition-group name="fade" tag="div">
                    <notification-item
                        v-for="(notification, index) in notifications"
                        :key="notification.id"
                        :index="index"
                        :mark-as-read-url="markAsReadUrl(notification.id)" />
                </transition-group>

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
        inviteUrlPattern: String,
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
