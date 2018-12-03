<template>
    <div id="entry-header" class="bg-white border-bottom">

        <nav v-if="displayEntryNav" class="nav justify-content-between row no-gutters">
            <div class="col-2 col-md-4">
                <a v-if="entry.action_urls.previous" class="nav-item nav-link" :href="entry.action_urls.previous">
                    <font-awesome-icon icon="backward" />
                    <span class="d-none d-md-inline ml-2">Previous</span>
                </a>
            </div>
            <div class="text-center">
                <a class="nav-item nav-link" :href="entry.journal.action_urls.contents">
                    <font-awesome-icon :icon="['fab', 'readme']" />
                    <span class="journal-title font-weight-bold">{{ entry.journal.title }}</span>
                </a>
            </div>
            <div class="col-2 col-md-4 text-right">
                <a v-if="entry.action_urls.next" class="nav-item nav-link" :href="entry.action_urls.next">
                    <span class="d-none d-md-inline mr-2">Next</span>
                    <font-awesome-icon icon="forward" />
                </a>
            </div>
        </nav>

        <div class="mx-4 mt-4 py-2">
            <h2 id="entry-title" class="mb-0"><slot></slot></h2>
            <small v-if="displayEntryNav" class="entry-meta text-muted">Written {{ updatedAt }} by {{ entry.author.name }}</small>
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
        }
    },

    computed: {
        entry: function() {
            return JSON.parse(this.entryJson);
        },
        createdAt: function() {
            return Moment(this.entry.created_at).calendar(null, this.$root.dateFormatObj);
        },
        updatedAt: function() {
            return Moment(this.entry.updated_at).calendar(null, this.$root.dateFormatObj);
        },
    }
}
</script>

