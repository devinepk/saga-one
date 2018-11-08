<template>

    <div class="row no-gutters fixed-bottom justify-content-end">
        <form method="post" class="d-none" :id="formId" :action="storeUrl">
            <slot></slot>
            <input type="hidden" name="journal_id" :value="journalId">
            <input type="hidden" name="body" :value="entryBody">
        </form>

        <button type="submit" :form="formId" class="col-md-9 btn btn-primary">Save</button>
    </div>

</template>

<script>
export default {
    props: {
        formId: {
            type: String,
            required: true
        },
        storeUrl: {
            type: String,
            required: true
        },
        journalId: {
            type: Number,
            required: true
        }
    },

    mounted: function() {
        let self = this;
        Event.$on('quill-input', function(input) {
            self.entryBody = input;
        });
    },

    data: function() {
        return {
            entryBody: ''
        };
    }
}
</script>
