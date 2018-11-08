<template>
<div class="modal fade" :id="modalId" tabindex="-1" role="dialog" :aria-labelledby="titleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" :id="titleId"><slot name="title"></slot></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <slot></slot>
            </div>
            <div class="modal-footer">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        modalId: {
            type: String,
            required: true
        }
    },
    computed: {
        titleId: function() {
            return this.modalId + "-title";
        }
    }
}
</script>
