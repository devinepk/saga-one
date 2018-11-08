<template>
<div class="card mb-5">
    <div class="card-header">
        <div v-if="editUrl || deleteUrl" class="float-right text-muted">
            <a v-if="editUrl" class="btn" :href="editUrl"><font-awesome-icon icon="edit" /></a>
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#delete-confirm">
                <font-awesome-icon icon="trash-alt"></font-awesome-icon>
            </button>

            <modal modal-id="delete-confirm">
                <template slot="title">Delete this entry?</template>
                <p>Are you sure you want to delete this entry?</p>
                <p class="text-center"><strong>{{ title }}</strong></p>
                <template slot="footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <form v-if="deleteUrl" class="d-inline" method="post" :action="deleteUrl">
                        <slot name="deleteformfields"></slot>
                        <button type="submit" class="btn btn-danger">Yes, delete</button>
                    </form>
                </template>
            </modal>

        </div>
        <h2 class="m-0"><a :href="titleUrl">{{ title }}</a><span v-if="unread" class="badge badge-info ml-3 rounded">unread</span></h2>
    </div>
    <div class="card-body position-relative">
        <div class="excerpt-overlay"></div>
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

<style scoped>
.excerpt-overlay {
    background: linear-gradient(to bottom, rgba(255,255,255,0) 50%,rgba(255,255,255,1) 100%);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
</style>
