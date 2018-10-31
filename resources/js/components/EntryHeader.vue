<template>
<div id="entry-header" class="sticky-top bg-white border-bottom" :class="{ belowTopbar: belowTopbar }">

    <nav v-if="displayEntryNav" class="nav justify-content-between mb-4">
        <a class="nav-item nav-link" href="#"><i class="fas fa-backward mr-2"></i><span class="d-none d-md-inline">Previous Entry</span></a>
        <a class="nav-item nav-link" href="#">Table of Contents</a>
        <a class="nav-item nav-link" href="#"><span class="d-none d-md-inline">Next Entry</span><i class="fas fa-forward ml-2"></i></a>
    </nav>

    <div v-if="editUrl" class="float-right m-2">
        <a class="text-muted" href="#"><i class="fas fa-edit"></i></a>
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
