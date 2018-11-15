<template>
    <div class="card mb-5">
        <h2 class="card-header">Participants</h2>
        <div class="table-responsive">
        <table class="table table-hover small text-nowrap border-bottom mb-0">
            <thead>
                <tr><th class="border-top-0 border-dark">Name</th><th class="border-top-0 border-dark">Email</th><th class="border-top-0 border-dark">Status</th><th class="border-top-0 border-dark">&nbsp;</th></tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="'user' + index">
                    <td>
                        {{ user.name }}
                        <template v-if="user.id == authUser.id">(you)</template>
                    </td>
                    <td>{{ user.email }}</td>
                    <td>Joined {{ on(user.subscription.created_at) }}</td>
                    <td>&nbsp;</td>
                </tr>

                <tr v-for="invite in pendingInvites" :key="'invite' + invite.id">
                    <td>
                        {{ invite.name }}
                        <span class="ml-1 p-1 badge badge-secondary" data-toggle="tooltip" data-placement="top" title="An invitation to join this journal has been sent to this user">invited</span>
                    </td>
                    <td>{{ invite.email }}</td>
                    <td>Invited {{ on(invite.updated_at) }}</td>
                    <td>
                        <a :href="resendUrl(invite.id)" data-toggle="tooltip" data-placement="top" title="Resend this invite">
                            <font-awesome-icon icon="envelope" />
                        </a>
                    </td>
                </tr>

                <tr v-for="invite in declinedInvites" class="text-black-50 font-italic" :key="'invite' + invite.id">
                    <td>
                        {{ invite.name }}
                        <span class="ml-1 p-1 badge badge-danger" data-toggle="tooltip" data-placement="top" title="This user has declined to join this journal">declined</span>
                    </td>
                    <td>{{ invite.email }}</td>
                    <td>Declined {{ on(invite.declined_at) }}</td>
                    <td>
                        <a :href="resendUrl(invite.id)" data-toggle="tooltip" data-placement="top" title="Resend this invite">
                            <font-awesome-icon icon="envelope" />
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>
        </div>

        <div class="card-body">
            <h4>Invite someone to join this journal</h4>

            <form v-if="authUserCanInvite && inviteUrl" method="post" :action="inviteUrl" class="form-inline">
                <slot></slot>

                <label for="name" class="sr-only">Name</label>
                <input type="name" class="form-control mb-1 mr-2" size="25" id="name" name="name" placeholder="Name" required>
                    <span v-if="nameError" class="invalid-feedback" role="alert">
                        <strong>{{ nameError }}</strong>
                    </span>
                <label for="email" class="sr-only">Email address</label>
                <input type="email" class="form-control mb-1 mr-2" size="25" id="email" name="email" placeholder="Email" required>
                    <span v-if="emailError" class="invalid-feedback" role="alert">
                        <strong>{{ emailError }}</strong>
                    </span>
                <button type="submit" class="btn btn-primary mb-1">Invite</button>
            </form>

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
        nameError: {
            type: String,
            default: ''
        },
        emailError: {
            type: String,
            default: ''
        },
        verificationResendUrl: {
            type: String,
            default: ''
        }
    },

    mounted() {
        $('[data-toggle="tooltip"]').tooltip();
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
        users: function() {
            return JSON.parse(this.usersJson);
        },
        invites: function() {
            return JSON.parse(this.invitesJson);
        },
        pendingInvites: function() {
            return this.invites.filter((item) => !item.declined_at && !item.accepted_at);
        },
        declinedInvites: function() {
            return this.invites.filter((item) => item.declined_at);
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
        }
    }
}
</script>
