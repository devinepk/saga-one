<template>
<div id="entry-header" class="sticky-top bg-white border-bottom" :class="{ belowTopbar: belowTopbar }">

    <nav v-if="displayEntryNav" class="nav justify-content-between mb-4">
        <a class="nav-item nav-link" href="#"><font-awesome-icon icon="backward" /><span class="d-none d-md-inline ml-2">Previous Entry</span></a>
        <a class="nav-item nav-link" href="#">Table of Contents</a>
        <a class="nav-item nav-link" href="#"><span class="d-none d-md-inline mr-2">Next Entry</span><font-awesome-icon icon="forward" /></a>
    </nav>

    <div v-if="editUrl" class="float-right m-2">
        <a class="text-muted" href="#"><font-awesome-icon icon="edit" /></a>
    </div>

    <div class="m-2">
        <h1 class="entry-title mb-0"><slot></slot></h1>
        <small v-if="createdOn" class="entry-meta text-muted">Written on {{ createdOn }} by <a :href="authorUrl">{{ author }}</a></small>
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
        createdOn: {
            type: String,
            required: false,
            default: ''
        },
        author: {
            type: String,
            required: false,
            default: ''
        },
        authorUrl: {
            type: String,
            required: false,
            default: '#'
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
