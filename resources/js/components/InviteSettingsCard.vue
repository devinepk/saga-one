<template>
    <div class="card mb-5">
        <h2 class="card-header">Invites</h2>
        <div class="table-responsive">
        <table v-if="invites.length" class="table table-hover small text-nowrap border-bottom mb-0">
            <thead>
                <tr>
                    <th class="border-top-0 action-col">&nbsp;</th>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Email</th>
                    <th class="border-top-0">Status</th>
                </tr>
            </thead>
            <tbody>

                <tr v-for="invite in [...acceptedInvites, ...pendingInvites, ...declinedInvites]" :key="'invite' + invite.id">
                    <td class="align-middle action-col">
                        <template v-if="invite.accepted_at">&nbsp;</template>
                        <template v-else>
                            <a :href="resendUrl(invite.id)" class="action px-1 py-0" data-toggle="tooltip" data-placement="top" title="Resend this invite">
                                <font-awesome-icon icon="envelope" />
                            </a>
                            <form method="POST" :action="deleteUrl(invite.id)" class="d-inline">
                                <input type="hidden" name="_token" :value="csrf">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="action btn btn-sm btn-link px-1 py-0" data-toggle="tooltip" data-placement="top" title="Delete this invite">
                                    <font-awesome-icon icon="trash-alt" />
                                </button>
                            </form>
                        </template>
                    </td>

                    <td class="align-middle">{{ invite.name }}</td>

                    <td class="align-middle">{{ invite.email }}</td>

                    <td class="align-middle" data-toggle="tooltip" data-placement="left" data-html="true" :title="toolTip(invite)">
                        <span class="p-1 badge text-uppercase" :class="badgeClass(invite)">{{ status(invite) }}</span> {{ on(invite.updated_at) }}
                    </td>
                </tr>

            </tbody>
        </table>
        </div>

        <div class="card-body">
            <h4>Invite someone to join this journal</h4>

            <template v-if="authUserCanInvite && inviteUrl">
                <form method="post" :action="inviteUrl" class="form-inline position-relative">
                    <input type="hidden" name="_token" :value="csrf">

                    <label for="name" class="sr-only">Name</label>
                    <input type="name" class="form-control mb-1 mr-2" :class="{ 'is-invalid': errors.name }" size="25" id="name" name="name" placeholder="Name" :value="oldName" required>
                    <span v-if="errors.name" class="invalid-tooltip" role="alert">
                        <strong>{{ errors.name[0] }}</strong>
                    </span>

                    <label for="email" class="sr-only">Email address</label>
                    <input type="email" class="form-control mb-1 mr-2" :class="{ 'is-invalid': errors.email }" size="25" id="email" name="email" placeholder="Email" :value="oldEmail" required>
                    <span v-if="errors.email" class="invalid-tooltip" role="alert">
                        <strong>{{ errors.email[0] }}</strong>
                    </span>

                    <button type="submit" class="btn btn-primary mb-1">Invite</button>
                </form>

            </template>
            <alert v-else level="danger" :dismissible="false" class="mb-0">

                <p>Only verified users can invite others to join a journal. You have not yet verified your email address.</p>
                <p>Please check your email for a verification link. If you did not receive the email, <a :href="verificationResendUrl" class="alert-link">click here to request another</a>.</p>

            </alert>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        authUserJson:          { type: String, default: '{}' },
        usersJson:             { type: String, default: '{}' },
        invitesJson:           { type: String, default: '{}' },
        authUserCanInvite:     { type: Boolean, default: false },
        inviteUrl:             { type: String, default: '' },
        oldName:               { type: String, default: '' },
        oldEmail:              { type: String, default: '' },
        verificationResendUrl: { type: String, default: '' },
        errorsJson:            { type: String, default: '{}' },
        csrf:                  { type: String, required: true }
    },

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        },
        invites: function() {
            return JSON.parse(this.invitesJson);
        },
        acceptedInvites: function () {
            return this.invites.filter((invite) => invite.accepted_at);
        },
        pendingInvites: function() {
            return this.invites.filter((invite) => !invite.declined_at && !invite.accepted_at);
        },
        declinedInvites: function() {
            return this.invites.filter((invite) => invite.declined_at);
        },
        errors: function() {
            return JSON.parse(this.errorsJson);
        }
    },

    methods: {
        on(date) {
            return Moment(date).calendar(null, this.$root.dateFormatObj);
        },
        inviteClassObj(invite) {
            if (invite.declined_at) {
                return {
                    'text-black-50': true,
                    'font-italic': true
                };
            }
            return {};
        },
        badgeClass(invite) {
            return {
                'badge-dark'     : invite.accepted_at,
                'badge-secondary': !invite.declined_at && !invite.accepted_at,
                'badge-danger'   : invite.declined_at
            };
        },
        resendUrl(invite) {
            return '/invite/' + invite + '/resend';
        },
        deleteUrl(invite) {
            return '/invite/' + invite;
        },
        toolTip(invite) {
            switch (this.status(invite)) {
                case 'Accepted': return "<strong>" + invite.name + "</strong> has <strong>accepted</strong> the invite to join this journal";
                case 'Declined': return "<strong>" + invite.name + "</strong> has <strong>declined</strong> to join this journal";
                case 'Invited' : return "<strong>" + invite.name + "</strong> has been <strong>invited</strong> to join this journal";
            }
        },
        status(invite) {
            if (invite.accepted_at) {
                return 'Accepted';
            }
            if (invite.declined_at) {
                return 'Declined';
            }
            // Default
            return 'Invited';
        }
    }
}
</script>

<style>
.action {
    font-size: initial;
}
.action-col {
    max-width: 50px;
}
</style>
