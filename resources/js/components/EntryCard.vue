<template>
<div class="card mb-5">
    <div class="card-header">
        <div v-if="editUrl || deleteUrl" class="float-right text-muted">
            <a v-if="editUrl" class="btn" :href="editUrl"><font-awesome-icon icon="edit" /></a>
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#delete-confirm">
                <font-awesome-icon icon="trash-alt"></font-awesome-icon>
            </button>


            <div class="modal fade" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="delete-confirm-title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delete-confirm-title">Delete this entry?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this entry?</p>
                        <p class="text-center"><strong>{{ title }}</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                        <form v-if="deleteUrl" class="d-inline" method="post" :action="deleteUrl">
                            <slot name="deleteformfields"></slot>
                            <button type="submit" class="btn btn-danger">Yes, delete</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
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
