<template>
    <div class="card mb-4">
        <h2 class="card-header"><slot name="title"></slot></h2>
        <table v-if="invites.length" class="table table-hover text-nowrap mb-0">
            <thead>
                <tr><th class="border-top-0">Journal</th><th class="border-top-0">Sender</th><th class="border-top-0">Date sent</th><th v-if="showViewBtn" class="border-top-0">&nbsp;</th></tr>
            </thead>
            <tbody>
                <tr v-for="invite in invites" :key="invite.id">
                    <td class="align-middle">{{ invite.journal.title }}</td>
                    <td class="align-middle">{{ invite.sender.name }}</td>
                    <td class="align-middle">{{ prettyDateSent(invite.updated_at) }}</td>
                    <td v-if="showViewBtn">
                        <a :href="viewUrl(invite.id)"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Respond to this invite"
                            class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else class="card-body">
            <p><slot name="empty"></slot></p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        inviteJson: {
            type: String,
            default: '{}'
        },
        showViewBtn: {
            type: Boolean,
            default: false
        }
    },

    mounted() {
        $('[data-toggle="tooltip"]').tooltip();
    },

    computed: {
        invites() {
            return JSON.parse(this.inviteJson);
        }
    },

    methods: {
        viewUrl(inviteId) {
            return '/invite/' + inviteId;
        },
        prettyDateSent(date) {
            return Moment(date).format('MMM D, YYYY [at] h:mma');
        }
    }

}
</script>
