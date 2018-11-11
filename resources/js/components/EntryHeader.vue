<template>
<div class="row no-gutters fixed-top justify-content-end">
    <div id="entry-header" class="col-md-9 bg-white border-bottom">

        <nav v-if="displayEntryNav" class="nav justify-content-between row no-gutters">
            <div class="col-2 col-md-4">
                <a v-if="previousUrl" class="nav-item nav-link" :href="previousUrl">
                    <font-awesome-icon icon="backward" />
                    <span class="d-none d-md-inline ml-2">Previous Entry</span>
                </a>
            </div>
            <div class="text-center">
                <a class="nav-item nav-link" :href="contentsUrl">Journal Contents</a>
            </div>
            <div class="col-2 col-md-4 text-right">
                <a v-if="nextUrl" class="nav-item nav-link" :href="nextUrl">
                    <span class="d-none d-md-inline mr-2">Next Entry</span>
                    <font-awesome-icon icon="forward" />
                </a>
            </div>
        </nav>

        <div v-if="editUrl" class="float-right m-2">
            <a class="text-muted" :href="editUrl"><font-awesome-icon icon="edit" /></a>
        </div>

        <div class="mx-4 mt-4 py-2">
            <h2 id="entry-title" class="entry-title mb-0"><slot></slot></h2>
            <small v-if="displayEntryNav" class="entry-meta text-muted">Written {{ updatedAt }} by {{ author.name }}</small>
        </div>

    </div>
</div>
</template>

<script>
module.exports = {
    props: {
        displayEntryNav: {
            type: Boolean,
            default: false
        },
        entryJson: {
            type: String,
            default: '{}'
        },
        authorJson: {
            type: String,
            required: true
        },
        editUrl: {
            type: String,
            default: ''
        },
        previousUrl: {
            type: String,
            default: ''
        },
        contentsUrl: {
            type: String,
            default: ''
        },
        nextUrl: {
            type: String,
            default: ''
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
            }
        };
    },

    computed: {
        entry: function() {
            return JSON.parse(this.entryJson);
        },
        author: function() {
            return JSON.parse(this.authorJson);
        },
        createdAt: function() {
            return Moment(this.entry.created_at).calendar(null, this.dateFormatObj);
        },
        updatedAt: function() {
            return Moment(this.entry.updated_at).calendar(null, this.dateFormatObj);
        },
    }
}
</script>

<style scoped>
.fixed-top {
    top: 38px;
    z-index: 10;
}
.entry-title {
    overflow: auto;
    white-space: nowrap;
}
</style>
