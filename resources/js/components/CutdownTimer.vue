<template>
    <div>{{hours}}h {{mins}}m {{secs}}s</div>
</template>
<script>

const dayjs = require('dayjs');
const utc = require('dayjs/plugin/utc')
const timezone = require('dayjs/plugin/timezone');
const duration = require('dayjs/plugin/duration');
dayjs.extend(utc);
dayjs.extend(timezone);
dayjs.extend(duration);

export default {
    data() {
        return {
            hours: 0,
            mins: 0,
            secs: 0,
        };
    },
    mounted() {
        setInterval(() => {
            const now = dayjs().tz('America/Los_Angeles');
            let next;
            if (now.hour() < 12) {
                next =  dayjs().tz('America/Los_Angeles').startOf('day').add(12, 'hours');
            } else {
                next =  dayjs().tz('America/Los_Angeles').endOf('day');
            }
            const diff = dayjs.duration(next.diff(now));
            this.hours = diff.hours();
            this.mins = diff.minutes();
            this.secs = diff.seconds();
        }, 1000);
    },
}
</script>