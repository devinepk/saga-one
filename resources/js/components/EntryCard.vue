<template>
<div class="card mb-5">
    <div class="card-header">
        <div v-if="editUrl || deleteUrl" class="float-right text-muted">
            <span data-toggle="tooltip" data-placement="top" title="Edit this entry">
                <a v-if="editUrl" class="btn" :href="editUrl">
                    <font-awesome-icon icon="edit" />
                </a>
            </span>
            <span data-toggle="tooltip" data-placement="top" title="Delete this entry">
                <button type="button" class="btn btn-link" data-toggle="modal" :data-target="deleteModalRef">
                    <font-awesome-icon icon="trash-alt" ></font-awesome-icon>
                </button>
            </span>

            <modal :modal-id="deleteModal">
                <template slot="title">Delete this entry?</template>
                <p>Are you sure you want to delete this entry?</p>
                <p class="text-center"><strong>{{ entry.title }}</strong></p>
                <template slot="footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <form v-if="deleteUrl" class="d-inline" method="post" :action="deleteUrl">
                        <slot name="deleteformfields"></slot>
                        <button type="submit" class="btn btn-danger">Yes, delete</button>
                    </form>
                </template>
            </modal>

        </div>
        <h2 class="m-0"><a :href="titleUrl">{{ entry.title }}</a><span v-if="unread" class="badge badge-info ml-3 rounded">unread</span></h2>
    </div>
    <div class="card-body position-relative">
        <div class="ql-editor" v-html="excerpt"></div>
    </div>
    <div class="card-footer text-muted">
        <span v-if="author.name">Written by {{ author.name }} {{ updatedAt }}.</span>
        <span v-else>Created {{ createdAt }}. Last updated {{ updatedAt }}.</span>
    </div>
</div>
</template>

<script>
export default {
    props: {
        entryJson: {
            type: String,
            required: true
        },
        authorJson: {
            type: String,
            default: '{}'
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
            required: true,
        },
        createdAtString: {
            type: String,
            required: false,
            default: ''
        },
        updatedAtString: {
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

    data() {
        return {
            dateFormatObj: {
                sameDay: '[today at] h:ssa',
                nextDay: '[tomorrow at] h:ssa',
                nextWeek: 'dddd [at] h:ssa',
                lastDay: '[yesterday at] h:ssa',
                lastWeek: '[last] dddd [at] h:ssa',
                sameElse: 'DD/MM/YYYY [at] h:ssa'
            },
            excerptOptions: {
                TruncateLength: 50,
                TruncateBy : "words",
                Strict : false,
                StripHTML : false,
                Suffix : '...'
            }
        };
    },

    mounted() {
        $('[data-toggle="tooltip"]').tooltip();
    },

    computed: {
        entry: function() {
            return JSON.parse(this.entryJson);
        },
        excerpt: function() {
            return Truncatise(this.entry.body, this.excerptOptions);
        },
        author: function() {
            return JSON.parse(this.authorJson);
        },
        createdAt: function() {
            return Moment(this.createdAtString).calendar(null, this.dateFormatObj);
        },
        updatedAt: function() {
            return Moment(this.updatedAtString).calendar(null, this.dateFormatObj);
        },
        deleteModal: function() {
            return 'delete-confirm-' + this.entry.id;
        },
        deleteModalRef: function() {
            return '#' + this.deleteModal;
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
.ql-editor {
    min-height: unset;
    padding: 0;
}
</style>
