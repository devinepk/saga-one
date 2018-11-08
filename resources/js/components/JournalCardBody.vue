<template>
<div class="card-body">
    <h3 class="card-title">
        <a v-if="showUrl" :href="showUrl"><slot></slot></a>
        <slot v-else></slot>
    </h3>

    <p v-if="description" class="font-italic">{{ description }}</p>

    <div class="row">

        <div class="col-lg mb-3 text-center">

            <a v-if="showUrl" :href="showUrl"><img :src="imageUrl" width="150" height="217"></a>
            <img v-else :src="imageUrl" width="150" height="217">

        </div>

        <div class="col-lg">
            <nav class="nav flex-column">


                <a v-if="showUrl" class="nav-link py-1" :href="showUrl">
                    <font-awesome-icon icon="pencil-alt"/>
                    <span class="ml-2">Write</span>
                </a>

                <a v-if="contentsUrl" class="nav-link py-1" :href="contentsUrl">
                    <font-awesome-icon icon="book-reader"/>
                    <span class="ml-2">Read</span>
                </a>

                <a v-if="inviteUrl" class="nav-link py-1" :href="inviteUrl">
                    <font-awesome-icon icon="user-plus"/>
                    <span class="ml-2">Invite</span>
                </a>

                <a v-if="editUrl" class="nav-link py-1" :href="editUrl">
                    <font-awesome-icon icon="edit"></font-awesome-icon>
                    <span class="ml-2">Edit</span>
                </a>

                <template v-if="archiveUrl">

                    <button type="button" class="btn btn-link nav-link border-0 text-left py-1" data-toggle="modal" data-target="#archive-confirm">
                        <font-awesome-icon icon="archive"></font-awesome-icon>
                        <span class="ml-2">Archive</span>
                    </button>

                    <modal modal-id="archive-confirm">
                        <template slot="title">Archive this journal?</template>
                        <p>Archived journals are "sealed" and can no longer be written in or edited in any way.</p>
                        <p>They are also removed from rotation, which means everyone in the journal will be able to read it anytime.</p>
                        <p>Are you sure you want to archive this journal?</p>
                        <template slot="footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                            <form class="d-inline" method="post" :action="archiveUrl">
                                <slot name="csrf"></slot>
                                <slot name="methodput"></slot>
                                <button type="submit" class="btn btn-danger">Yes, archive</button>
                            </form>
                        </template>
                    </modal>

                </template>

            </nav>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        description: {
            type: String,
            required: false,
            default: ''
        },
        showUrl: {
            type: String,
            required: false,
            default: ''
        },
        contentsUrl: {
            type: String,
            required: false,
            default: ''
        },
        imageUrl: {
            type: String,
            required: false,
            default: ''
        },
        inviteUrl: {
            type: String,
            required: false,
            default: ''
        },
        editUrl: {
            type: String,
            required: false,
            default: ''
        },
        archiveUrl: {
            type: String,
            required: false,
            default: ''
        }
    }
}
</script>
