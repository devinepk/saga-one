<template>
<div class="clearfix">
    <div class="float-left" style="width:13px;"><i class="fas fa-user"></i></div>
    <div style="margin-left: 20px;">
        <p><span class="comment-author font-weight-bold">{{ author }}</span>
            <slot></slot>
        </p>
    </div>
</div>
</template>

<script>
module.exports = {
    props: ['author']
}
</script>
