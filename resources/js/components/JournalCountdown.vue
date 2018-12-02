<template>
<div>
    <transition name="fade">
        <alert v-if="error" level="danger" :dismissible="false">Journal rotation failed. Please refresh this page.</alert>
    </transition>

    <div class="card mb-4">
        <div class="row no-gutters justify-content-center text-light text-center font-weight-bold">
            <div class="col">
                <div :class="bgColorClass" class="py-2">
                    <p class="m-0 h2">{{ days.value }}</p>
                    <p class="m-0">{{ days.string }}</p>
                </div>
            </div>
            <div class="col">
                <div :class="bgColorClass" class="py-2">
                    <p class="m-0 h2">{{ hours.value }}</p>
                    <p class="m-0">{{ hours.string }}</p>
                </div>
            </div>
            <div class="col">
                <div :class="bgColorClass" class="py-2">
                    <p class="m-0 h2">{{ minutes.value }}</p>
                    <p class="m-0">{{ minutes.string }}</p>
                </div>
            </div>
            <div class="col">
                <div :class="bgColorClass" class="py-2">
                    <p class="m-0 h2">{{ seconds.value }}</p>
                    <p class="m-0">{{ seconds.string }}</p>
                </div>
            </div>
        </div>

        <transition name="fade">
            <div v-if="loading" class="text-center p-2">
                <font-awesome-icon icon="spinner" :spin="true" />
            </div>
            <alert v-if="showTurnOverMessage" level="danger" :icon="false" :dismissible="false" class="mb-0">Your turn with this journal has ended. <strong>{{ $root.journal.title }}</strong> has passed on to <strong>{{ $root.journal.current_user.name }}</strong>.</alert>
        </transition>

        <p class="mb-0 card-body">While you have this journal, you can read previous entries as well as add new ones. The entries you add now can be edited later as long as you have this journal, but once your turn is over, they will be published to the journal permanently. <strong>So make sure your entries are finished before the timer runs out!</strong></p>

        <a class="btn btn-block btn-primary" :href="addEntryUrl">
            <font-awesome-icon icon="plus"></font-awesome-icon>
            <span class="ml-2">Add a new entry</span>
        </a>
    </div>

    <alert v-if="!entryCount && !timeIsUp" level="secondary" :dismissible="false">You haven't added any entries yet. Time to get writing!</alert>
</div>
</template>

<script>
module.exports = {
    props: {
        targetDateString: {
            type: String,
            required: true
        },
        rotateUrl: {
            type: String,
            required: true
        },
        addEntryUrl: {
            type: String,
            required: true
        },
        entryCount: {
            type: Number,
            required: true
        }
    },

    data: function() {
        return {
            targetDate: null,
            showTurnOverMessage: false,
            diff: Infinity,
            error: false,
            loading: false
        }
    },

    mounted: function() {
        this.targetDate = Moment(this.targetDateString);
        requestAnimationFrame(this.updateRemaining);
    },

    computed: {
        weeks: function() {
            let val = Moment.duration(this.diff).weeks();
            return {
                value: val,
                string: val === 1 ? 'week' : 'weeks'
            }
        },

        days: function() {
            let val = Moment.duration(this.diff).days();
            return {
                value: val,
                string: val === 1 ? 'day' : 'days'
            }
        },

        hours: function() {
            let val = Moment.duration(this.diff).hours();
            return {
                value: val,
                string: val === 1 ? 'hour' : 'hours'
            }
        },

        minutes: function() {
            let val = Moment.duration(this.diff).minutes();
            return {
                value: val,
                string: val === 1 ? 'minute' : 'minutes'
            }
        },

        seconds: function() {
            let val = Moment.duration(this.diff).seconds();
            return {
                value: val,
                string: val === 1 ? 'second' : 'seconds'
            }
        },

        bgColorClass: function() {
            if (this.diff > 60000) return 'bg-primary';
            return 'bg-danger';
        },

        timeIsUp: function() {
            // Time is up if there is less than a second left.
            return this.diff < 100;
        }
    },

    methods: {
        updateRemaining: function() {
            this.diff = this.targetDate.diff(Moment());
            if (this.timeIsUp) {
                // Post to the server to update the journal
                this.triggerRotation();
            } else {
                requestAnimationFrame(this.updateRemaining);
            }
        },

        triggerRotation: function() {
            let self = this;

            self.loading = true;

            // Post to the app to trigger a journal rotation
            axios.post(self.rotateUrl)
                .then(function(response) {
                    self.$root.journal = response.data;
                    self.loading = false;
                    self.showTurnOverMessage = true;
                })
                .catch(function(error) {
                    self.error = true;
                    console.error(error.response);
                });
        }
    }
}
</script>
