<template>
<div>
    <h2>Time Remaining</h2>

    <div class="row no-gutters justify-content-center text-light text-center font-weight-bold my-4">
        <div class="col">
            <div class="bg-primary py-2 rounded-left">
                <p class="m-0 h2">{{ days.value }}</p>
                <p class="m-0">{{ days.string }}</p>
            </div>
        </div>
        <div class="col">
            <div class="bg-primary py-2">
                <p class="m-0 h2">{{ hours.value }}</p>
                <p class="m-0">{{ hours.string }}</p>
            </div>
        </div>
        <div class="col">
            <div class="bg-primary py-2">
                <p class="m-0 h2">{{ minutes.value }}</p>
                <p class="m-0">{{ minutes.string }}</p>
            </div>
        </div>
        <div class="col">
            <div class="bg-primary rounded-right py-2">
                <p class="m-0 h2">{{ seconds.value }}</p>
                <p class="m-0">{{ seconds.string }}</p>
            </div>
        </div>
    </div>
</div>
</template>

<script>
module.exports = {
    props: ['targetDateString'],

    data: function() {
        return {
            targetDate: null,
            diff: null
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
        }
    },

    methods: {
        updateRemaining: function() {
            this.diff = this.targetDate.diff(Moment());
            requestAnimationFrame(this.updateRemaining);
        }
    }
}
</script>
