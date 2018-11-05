<template>
<table class="my-3">
    <tr><th>Countdown:</th><td>{{ remaining }}</td></tr>
</table>
</template>

<script>
module.exports = {
    props: ['targetDateString'],

    data: function() {
        return {
            targetDate: null,
            remaining: ''
        }
    },

    mounted: function() {
        this.targetDate = Moment(this.targetDateString);
        setInterval(this.updateRemaining, 250);
        // this.updateRemaining();
    },

    methods: {
        updateRemaining: function() {
            let diff = this.targetDate.diff(Moment());
            this.remaining = Moment.duration(diff).format('w [week], d [day], h [hour], m [minute], [and] s [second]');
        }
    }
}
</script>
