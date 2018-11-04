<template>
<div class="card mb-5">
    <div class="card-header">
        <a v-if="editUrl" class="float-right m-2 text-muted" :href="editUrl"><font-awesome-icon icon="edit" /></a>
        <h2 class="m-0"><a :href="readUrl">{{ title }}</a><span v-if="unread" class="badge badge-info ml-3 rounded">unread</span></h2>
    </div>
    <div class="card-body">
        <p class="m-0 excerpt"><slot></slot></p>
    </div>
    <div class="card-footer text-muted">
        <span v-if="author">Written by {{ author }} on {{ updatedAt }}.</span>
        <span v-else>Created on {{ createdAt }}. Last updated on {{ updatedAt }}.</span>
    </div>
</div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        editUrl: {
            type: String,
            required: false,
            default: ''
        },
        readUrl: {
            type: String,
            required: true
        },
        author: {
            type: String,
            required: false,
            default: ''
        },
        createdAt: {
            type: String,
            required: false,
            default: ''
        },
        updatedAt: {
            type: String,
            required: false,
            default: ''
        },
        unread: {
            type: Boolean,
            required: false,
            default: false
        }
    }
}
</script>
