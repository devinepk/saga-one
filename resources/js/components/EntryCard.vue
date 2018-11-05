<template>
<div class="card mb-5">
    <div class="card-header">
        <div v-if="editUrl || deleteUrl" class="float-right pt-1 text-muted">
            <a v-if="editUrl" class="m-2" :href="editUrl"><font-awesome-icon icon="edit" /></a>
            <a v-if="deleteUrl" class="m-2" href="#" @click="submitDeleteForm"><font-awesome-icon icon="trash-alt" /></a>
            <form class="d-none" ref="deleteForm" method="post" :action="deleteUrl">
                <slot name="deleteformfields"></slot>
            </form>
        </div>
        <h2 class="m-0"><a :href="titleUrl">{{ title }}</a><span v-if="unread" class="badge badge-info ml-3 rounded">unread</span></h2>
    </div>
    <div class="card-body">
        <p class="m-0 excerpt"><slot></slot></p>
    </div>
    <div class="card-footer text-muted">
        <span v-if="author">Written by {{ author }} {{ updatedAt }}.</span>
        <span v-else>Created {{ createdAt }}. Last updated {{ updatedAt }}.</span>
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
        deleteUrl: {
            type: String,
            required: false,
            default: ''
        },
        titleUrl: {
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
    },

    methods: {
        submitDeleteForm: function() {
            this.$refs.deleteForm.submit();
        }
    }
}
</script>
