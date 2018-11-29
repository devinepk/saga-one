<template>
    <font-awesome-icon
        icon="question-circle"
        data-toggle="tooltip"
        data-html="true"
        :data-placement="placement"
        :title="text"
    />
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true
        },
        placement: {
            type: String,
            default: "top",
            validator: (value) => ['top', 'bottom', 'left', 'right'].indexOf(value) > -1
        }
    }
}
</script>
