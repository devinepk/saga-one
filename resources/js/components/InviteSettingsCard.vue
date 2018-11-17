<template>
    <div class="card mb-5">
        <h2 class="card-header">Invites</h2>
        <div class="table-responsive">
        <table class="table table-hover small text-nowrap border-bottom mb-0">
            <thead>
                <tr>
                    <th class="border-top-0 action-col">&nbsp;</th>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Email</th>
                    <th class="border-top-0">Status</th>
                </tr>
            </thead>
            <tbody>

                <tr v-for="invite in pendingInvites" :key="'invite' + invite.id">
                    <td class="align-middle action-col">
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
                    </td>
                    <td class="align-middle">
                        {{ invite.name }}
                    </td>
                    <td class="align-middle">{{ invite.email }}</td>
                    <td class="align-middle">
                        <span class="p-1 badge badge-secondary text-uppercase" data-toggle="tooltip" data-placement="top" :title="invitedTip(invite.name)">invited</span> {{ on(invite.updated_at) }}
                    </td>
                </tr>

                <tr v-for="invite in declinedInvites" class="text-black-50" :key="'invite' + invite.id">
                    <td class="align-middle action-col">
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
                    </td>
                    <td class="align-middle">
                        {{ invite.name }}
                    </td>
                    <td class="align-middle">{{ invite.email }}</td>
                    <td class="align-middle">
                        <span class="p-1 badge badge-danger text-uppercase" data-toggle="tooltip" data-placement="top" :title="declinedTip(invite.name)">declined</span> {{ on(invite.declined_at) }}
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
        authUserJson: {
            type: String,
            default: '{}'
        },
        usersJson: {
            type: String,
            default: '{}'
        },
        invitesJson: {
            type: String,
            default: '{}'
        },
        authUserCanInvite: {
            type: Boolean,
            default: false
        },
        inviteUrl: {
            type: String,
            default: ''
        },
        oldName: {
            type: String,
            default: ''
        },
        oldEmail: {
            type: String,
            default: ''
        },
        verificationResendUrl: {
            type: String,
            default: ''
        },
        errorsJson: {
            type: String,
            default: '{}'
        },
        csrf: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            dateFormatObj: {
                sameDay: '[today at] h:ssa',
                nextDay: '[tomorrow at] h:ssa',
                nextWeek: 'dddd [at] h:ssa',
                lastDay: '[yesterday at] h:ssa',
                lastWeek: '[last] dddd [at] h:ssa',
                sameElse: 'DD/MM/YYYY [at] h:ssa'
            }
        };
    },

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        },
        invites: function() {
            return JSON.parse(this.invitesJson);
        },
        pendingInvites: function() {
            return this.invites.filter((item) => !item.declined_at && !item.accepted_at);
        },
        declinedInvites: function() {
            return this.invites.filter((item) => item.declined_at);
        },
        errors: function() {
            return JSON.parse(this.errorsJson);
        }
    },

    methods: {
        on(date) {
            return Moment(date).calendar(null, this.dateFormatObj);
        },
        inviteClassObj(invite) {
            let classObj = {};
            if (invite.declined_at) {
                classObj = {
                    'text-black-50': true,
                    'font-italic': true
                }
            }
            return classObj;
        },
        resendUrl(invite) {
            return '/invite/' + invite + '/resend';
        },
        deleteUrl(invite) {
            return '/invite/' + invite;
        },
        invitedTip(name) {
            return "An invitation to join has been sent to " + name;
        },
        declinedTip(name) {
            return name + " has declined to join this journal";
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
