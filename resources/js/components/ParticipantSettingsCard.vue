<template>
    <div class="card mb-5">
        <h2 class="card-header">Participants</h2>
        <div class="card-body">
            <p class="m-0">Drag and drop the journal participants below to set the turn order you like. You may change the order at any time, but altering the order won't change who has the journal right now.</p>
        </div>
        <div class="table-responsive position-relative">
            <table class="table table-hover small text-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0">&nbsp;</th>
                        <th class="border-top-0">&nbsp;</th>
                        <th class="border-top-0">Name</th>
                        <th class="border-top-0">Email</th>
                        <th class="border-top-0">Status</th>
                    </tr>
                </thead>
                <tbody id="participants">
                    <tr v-for="user in users" :key="'user' + user.id" :class="{ draggable: !isCurrentUser(user) }" :id="'user' + user.id">
                        <td class="align-middle text-center">
                            <a v-if="!isCurrentUser(user)" class="text-primary handle icon px-1" data-toggle="tooltip" data-placement="top" title="Drag to reorder">
                                <font-awesome-icon icon="grip-horizontal" />
                            </a>
                            <template v-else>&nbsp;</template>
                        </td>
                        <td class="align-middle">
                            <current-user-icon
                                v-if="isCurrentUser(user)"
                                :authCurrent="isCurrentUser(authUser)"
                                :currentUser="journal.current_user.name"
                                class="icon text-primary"
                            />
                            <template v-else>&nbsp;</template>
                        </td>
                        <td class="align-middle">
                            {{ user.name }} <span v-if="user.id == authUser.id" class="text-muted">(you)</span>
                        </td>
                        <td class="align-middle">{{ user.email }}</td>
                        <td class="align-middle">Joined {{ on(user.subscription.created_at) }}</td>
                    </tr>
                </tbody>
            </table>

            <transition name="fade">
                <div v-if="savingInProgress" class="saving-overlay text-light d-flex justify-content-center align-items-center">
                    <p class="h1">
                        <font-awesome-icon icon="spinner" :spin="true" />
                        <span class="ml-1">Saving...</span>
                    </p>
                </div>
            </transition>

        </div>
    </div>
</template>

<script>
export default {
    props: {
        authUserJson: {
            type: String,
            default: '{}'
        },
        usersJson: {
            type: String,
            default: '{}'
        },
        queueUrl: {
            type: String,
            required: true
        }
    },

    mounted() {
        let self = this;

        $( '#participants' ).sortable({
            placeholder: "ui-state-highlight bg-secondary",
            items: ".draggable",
            axis: "y",
            cursor: "move",
            handle: ".handle",
            scroll: false,
            update: self.postQueueUpdate
        });
    },

    data() {
        return {
            savingInProgress: false
        };
    },

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        },
        users: function() {
            return JSON.parse(this.usersJson);
        },
        journal: function() {
            // Grab the journal stored on the root instance.
            // Use a computed property because direct calls to $root may be made
            // before the journal is loaded there.
            return this.$root.journal;
        }
    },

    methods: {
        on(date) {
            return Moment(date).calendar(null, this.dateFormatObj);
        },

        isCurrentUser(user) {
            return user.id == this.journal.current_user.id;
        },

        postQueueUpdate(event, ui) {
            let self = this;
            self.savingInProgress = true;

            let new_queue = $( "#participants" ).sortable( "toArray" );

            // Prepend the current user (which isn't draggable) to the new_queue
            new_queue.unshift("user" + this.journal.current_user.id);
            console.log(new_queue);

            // Post to the app to save the new queue
            axios.post(self.queueUrl, { new_queue: new_queue } )
                .then(function (response) {
                    setTimeout(() => { self.savingInProgress = false; }, 1000);
                    Event.$emit('queueUpdated', { new_queue: new_queue } );
                })
                .catch(function (error) {
                    console.error(error);
                });
        }
    }
}
</script>

<style scoped>
.icon {
    font-size: initial;
}
.handle {
    cursor: move;
}
.saving-overlay {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    -webkit-box-shadow: inset 0 0 50px 5px #FFFFFF;
    box-shadow: inset 0 0 50px 5px #FFFFFF;
    transition:0.2s;
}
</style>
