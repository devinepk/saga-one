<template>
<div class="card journal-card mb-5">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <a v-if="writeUrl" :href="writeUrl">{{ journal.title }}</a>
            <template v-else>{{ journal.title }}</template>
        </h3>

        <p v-if="journal.description" class="font-italic mb-0">{{ journal.description }}</p>
    </div>

    <div class="journal-card-cover" :style="{'background-image': 'url(' + imageUrl + ')'}">
        <a v-if="writeUrl" :href="writeUrl"></a>
    </div>

    <div v-if="writeUrl || readUrl || settingsUrl" class="row no-gutters bg-secondary" role="group" aria-label="Journal actions">
        <div class="col-4">
            <a v-if="writeUrl" :href="writeUrl" class="btn btn-block btn-secondary" data-toggle="tooltip" data-placement="top" title="Write">
                <font-awesome-icon icon="pencil-alt" />
            </a>
        </div>
        <div class="col-4">
            <a v-if="readUrl" :href="readUrl" class="btn btn-block btn-secondary" data-toggle="tooltip" data-placement="top" title="Read">
                <font-awesome-icon icon="book-reader"/>
            </a>
        </div>
        <div class="col-4">
            <a v-if="settingsUrl" :href="settingsUrl" class="btn btn-block btn-secondary" data-toggle="tooltip" data-placement="top" title="Journal settings">
                <font-awesome-icon icon="cogs"></font-awesome-icon>
            </a>
        </div>
    </div>

    <template v-if="queue.length">
        <ul class="list-group list-group-flush">
            <li v-for="(user, index) in queue"
                :key="index"
                class="list-group-item list-group-item-action"
                :class="{active: index==0}"
            >

                <font-awesome-icon icon="user"></font-awesome-icon>

                <span class="ml-2">{{ user.name }}</span>

                <font-awesome-icon
                    v-if="user.id == journal.current_user.id"
                    icon="book-reader"
                    class="float-right mt-1"
                    data-toggle="tooltip" data-placement="top" :title="queueTip(user.id, user.name)"
                />

            </li>
        </ul>
    </template>

    <div v-else class="alert alert-secondary mb-0">
            The real fun begins when you share this journal with others. <strong><a :href="settingsUrl">Invite a friend</a> now!</strong>
    </div>

</div>
</template>

<script>
export default {
    props: {
        authUserJson: {
            type: String,
            required: true
        },
        writeUrl: {
            type: String,
            required: false,
            default: ''
        },
        readUrl: {
            type: String,
            required: false,
            default: ''
        },
        imageUrl: {
            type: String,
            required: false,
            default: ''
        },
        settingsUrl: {
            type: String,
            required: false,
            default: ''
        },
        queueJson: {
            type: String,
            default: '{}'
        },
        journalJson: {
            type: String,
            default: '{}'
        }
    },

    mounted() {
        $('[data-toggle="tooltip"]').tooltip();
    },

    computed: {
        authUser: function() {
            return JSON.parse(this.authUserJson);
        },
        queue: function() {
            return JSON.parse(this.queueJson);
        },
        journal: function() {
            return JSON.parse(this.journalJson);
        }
    },

    methods: {
        queueTip: function(id, name) {
            if (id == this.authUser.id) {
                return "You have this journal right now."
            }
            return name + " has this journal right now."
        }
    }
}
</script>
