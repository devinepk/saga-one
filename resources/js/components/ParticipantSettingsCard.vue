<template>
    <div class="card mb-5">

        <div class="card-header">
            <transition name="fade">
                <span v-if="saveStatus" class="float-right mt-1" :class="saveClass">{{ saveStatus }}</span>
            </transition>
            <h2 class="m-0">Participants</h2>
        </div>

        <div class="card-body">
            <p class="m-0">Drag and drop the journal participants below to set the turn order you like. You may change the order at any time, but altering the order won't change who has the journal right now.</p>
        </div>

        <div class="table-responsive position-relative">
            <table class="table table-hover small text-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0">&nbsp;</th>
                        <th class="border-top-0">Name</th>
                        <th class="border-top-0">Email</th>
                        <th class="border-top-0">Status</th>
                    </tr>
                </thead>
                <tbody id="participants">
                    <tr v-for="user in users" :key="'user' + user.id" :class="{ draggable: !isCurrentUser(user) }" :id="'user' + user.id">
                        <td class="align-middle text-center">
                            <current-user-icon
                                v-if="isCurrentUser(user)"
                                :authCurrent="isCurrentUser(authUser)"
                                :currentUser="journal.current_user.name"
                                class="icon text-primary"
                            />
                            <a v-else class="text-primary handle icon px-1" data-toggle="tooltip" data-placement="top" title="Drag to reorder">
                                <font-awesome-icon icon="grip-horizontal" />
                            </a>
                        </td>
                        <td class="align-middle">
                            {{ user.name }} <span v-if="user.id == authUser.id" class="text-muted">(you)</span>
                        </td>
                        <td class="align-middle">{{ user.email }}</td>
                        <td class="align-middle">Joined {{ on(user.subscription.created_at) }}</td>
                    </tr>
                </tbody>
            </table>
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

        // Take a snapshot of initial state in case we need to undo changes.
        this.rollback = $( "#participants" ).sortable( "toArray" );
    },

    data() {
        return {
            savingInProgress: false,
            rollback: null,
            savingInProgress: false,
            saveStatus: '',
            saveError: false
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
        },
        saveClass: function() {
            return {
                'text-muted': this.savingInProgress,
                'font-weight-bold': !this.savingInProgress,
                'text-primary': !this.saveError,
                'text-danger': this.saveError
            };
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
            self.saveStatus = 'Saving...';

            let new_queue = $( "#participants" ).sortable( "toArray" );

            // Prepend the current user (which isn't draggable) to the new_queue
            new_queue.unshift("user" + this.journal.current_user.id);

            // Post to the app to save the new queue
            axios.post(self.queueUrl, { new_queue: new_queue } )
                .then(function (response) {
                    Event.$emit('queueUpdateSuccess', response.data.new );
                    self.savingInProgress = false;
                    self.saveStatus = 'Saved!';
                    setTimeout(self.resetSaveStatus, 2000);
                })
                .catch(function (error) {
                    Event.$emit('queueUpdateFailure', self.rollback);
                    self.savingInProgress = false;
                    self.saveError = true;
                    self.saveStatus = 'Failed to save!';
                    setTimeout(self.resetSaveStatus, 2000);

                    if (error.response) {
                        console.error('Response received:', error.response);
                    } else if (error.request) {
                        console.error('Request sent:', error.request);
                    } else {
                        console.error('Config:', error.config);
                    }

                });
        },

        resetSaveStatus() {
            this.saveStatus = '';
            this.saveError = false;
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
