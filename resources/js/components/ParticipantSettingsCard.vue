<template>
    <div class="card mb-5">
        <h2 class="card-header">Participants</h2>
        <div class="table-responsive">
            <table class="table table-hover small text-nowrap mb-0">
                <thead>
                    <tr><th class="border-top-0">Name</th><th class="border-top-0">Email</th><th class="border-top-0">Status</th><th class="border-top-0">&nbsp;</th></tr>
                </thead>
                <tbody id="participants">
                    <tr v-for="user in users" :key="'user' + user.id" class="draggable">
                        <td class="align-middle">
                            {{ user.name }} <span v-if="user.id == authUser.id" class="text-muted">(you)</span>
                        </td>
                        <td class="align-middle">{{ user.email }}</td>
                        <td class="align-middle">Joined {{ on(user.subscription.created_at) }}</td>
                        <td class="align-middle text-right">
                            <a class="text-primary handle px-1" data-toggle="tooltip" data-placement="top" title="Drag to reorder"><font-awesome-icon icon="grip-horizontal" /></a>
                        </td>
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
    },

    mounted() {
        $('#participants').sortable({
            placeholder: "ui-state-highlight",
            items: ".draggable",
            axis: "y",
            cursor: "move",
            handle: ".handle"
        });
        $('#participants').disableSelection();
    },

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        },
        users: function() {
            return JSON.parse(this.usersJson);
        }
    },

    methods: {
        on(date) {
            return Moment(date).calendar(null, this.dateFormatObj);
        }
    }
}
</script>

<style>
.handle {
    font-size: initial;
    cursor: move;
}
</style>
