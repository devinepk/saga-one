<template>
    <div class="card mb-5">
        <h2 class="card-header">Participants</h2>
        <table class="table table-hover border-bottom mb-0">
            <thead>
                <tr><th class="border-top-0 border-dark">Name</th><th class="border-top-0 border-dark">Status</th></tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="'user' + index">
                    <td>
                        {{ user.name }}
                        <template v-if="user.id == authUser.id">(you)</template>
                    </td>
                    <td>Joined {{ user.subscription.created_at }}</td>
                </tr>

                <tr v-for="(invite, index) in invites" :key="'invite' + index">
                    <td>
                        {{ invite.name }} (invited)

                    </td>
                    <td>Invited {{ invite.created_at }}</td>
                </tr>

            </tbody>
        </table>

        <div class="card-body">
            <h4>Invite someone to join this journal</h4>

            <form v-if="authUserCanInvite && inviteUrl" method="post" :action="inviteUrl" class="form-inline">
                <slot name="csrf"></slot>

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
                <p>Please check your email for a verification link. If you did not receive the email, <a :href="verificationResendUrl" class="alert-link">'click here to request another</a>.</p>

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

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        },
        users: function() {
            return JSON.parse(this.usersJson);
        },
        invites: function() {
            return JSON.parse(this.invitesJson);
        }
    }
}
</script>
