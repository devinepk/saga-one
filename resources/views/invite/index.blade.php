@extends('layout.page')

@section('page-title', "Pending Invites")

@section('page-content')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4">Your invites</h1>
        </div>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8">
            <invite-card
                invite-json="{{ $pending_invites }}"
                :show-view-btn="true"
            >
                <template slot="title">Pending invites</template>
                <template slot="empty">You don't have any pending invites as this time.</template>
            </invite-card>
        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8">
            <invite-card
                invite-json="{{ $accepted_invites }}"
            >
                <template slot="title">Accepted invites</template>
                <template slot="empty">You haven't accepted any invites yet.</template>
            </invite-card>
        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8">
            <invite-card
                invite-json="{{ $declined_invites }}"
            >
                <template slot="title">Declined invites</template>
                <template slot="empty">You haven't declined any invites.</template>
            </invite-card>
        </div>

    </div>
@endsection
