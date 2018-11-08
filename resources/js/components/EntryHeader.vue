<template>
<div id="entry-header" class="sticky-top bg-white border-bottom" :class="{ belowTopbar: belowTopbar }">

    <nav v-if="displayEntryNav" class="nav justify-content-between mb-4 row no-gutters">
        <div class="col-2 col-md-4">
            <a v-if="previousUrl" class="nav-item nav-link" :href="previousUrl"><font-awesome-icon icon="backward" /><span class="d-none d-md-inline ml-2">Previous Entry</span></a>
        </div>
        <div class="text-center">
            <a class="nav-item nav-link" :href="contentsUrl">Table of Contents</a>
        </div>
        <div class="col-2 col-md-4 text-right">
            <a v-if="nextUrl" class="nav-item nav-link" :href="nextUrl"><span class="d-none d-md-inline mr-2">Next Entry</span><font-awesome-icon icon="forward" /></a>
        </div>
    </nav>

    <div v-if="editUrl" class="float-right m-2">
        <a class="text-muted" :href="editUrl"><font-awesome-icon icon="edit" /></a>
    </div>

    <div class="m-2">
        <h1 id="entry-title" class="entry-title mb-0"><slot></slot></h1>
        <small v-if="entryDate" class="entry-meta text-muted">Written on {{ entryDate }} by {{ author }}</small>
    </div>

</div>
</template>

<script>
module.exports = {
    props: {
        displayEntryNav: {
            type: Boolean,
            required: false,
            default: false
        },
        editUrl: {
            type: String,
            required: false,
            default: ''
        },
        entryDate: {
            type: String,
            required: false,
            default: ''
        },
        author: {
            type: String,
            required: false,
            default: ''
        },
        previousUrl: {
            type: String,
            required: false,
            default: ''
        },
        contentsUrl: {
            type: String,
            required: false,
            default: ''
        },
        nextUrl: {
            type: String,
            required: false,
            default: ''
        }
    },

    data: function() {
        return {
            belowTopbar: false
        }
    },

    mounted: function() {
        let self = this;
        window.addEventListener('scroll', _.throttle((e) => {
            self.belowTopbar = (window.pageYOffset > 0);
        }), 200);
    }
}
</script>
