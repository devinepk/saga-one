<template>
<div>
    <transition name="fade">
        <alert v-if="error" level="danger">Journal rotation failed. Please refresh this page.</alert>
    </transition>

    <div class="row no-gutters justify-content-center text-light text-center font-weight-bold mb-4">
        <div class="col">
            <div :class="bgColorClass" class="py-2 rounded-left">
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
            <div :class="bgColorClass" class="rounded-right py-2">
                <p class="m-0 h2">{{ seconds.value }}</p>
                <p class="m-0">{{ seconds.string }}</p>
            </div>
        </div>
    </div>

    <transition name="fade">
        <alert v-if="diff < 0"><strong>This journal has rotated to the next user. You'll have to wait until it's your turn again to read or write in it.</strong></alert>
    </transition>
</div>
</template>

<script>
module.exports = {
    props: ['targetDateString', 'rotateUrl'],

    data: function() {
        return {
            targetDate: null,
            diff: null,
            error: false
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
            if (this.diff > 10000) return 'bg-primary';
            return 'bg-danger';
        }
    },

    methods: {
        updateRemaining: function() {
            this.diff = this.targetDate.diff(Moment());
            if (this.diff >= 0) {
                requestAnimationFrame(this.updateRemaining);
            } else {
                // Post to the server to update the journal
                this.triggerRotation();
            }
        },

        triggerRotation: function() {
            let self = this;

            // Post to the app to trigger a journal rotation
            axios.post(self.rotateUrl)
                .then(function(response) {
                    Event.$emit('journalRotated');
                })
                .catch(function(error) {
                    self.error = true;
                    console.error(error.response);
                });
        }
    }
}
</script>
