<template>
<div class="card mb-5">
    <div class="card-header">
        <a class="float-right m-2 text-muted" :href="editUrl"><i class="fas fa-edit"></i></a>
        <h2 class="m-0"><a :href="readUrl">{{ title }}</a></h2>
    </div>
    <div class="card-body">
        <p class="m-0 excerpt"><slot></slot></p>
    </div>
    <div class="card-footer text-muted">
        <span>Written by <a :href="authorUrl">{{ author }}</a> on {{ createdOn }}</span>
    </div>
</div>
</template>

<script>
export default {
    props: {
        title: String,
        editUrl: String,
        readUrl: String,
        excerpt: String,
        author: String,
        authorUrl: String,
        createdOn: String
    }
}
</script>
