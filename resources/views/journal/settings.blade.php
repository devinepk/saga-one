@extends('layout.journal')

@section('page-title', "Journal Settings")

@section('journal-content')
<div class="container">

    @if (!Auth::user()->hasVerifiedEmail())
        <alert level="danger">
            Verify your email address to invite others to join this journal. Check your email for a verification link. (Or <a href="{{ route('verification.resend') }}" class="alert-link">click here to request another</a>.)
        </alert>
    @endif

    <h1><span class="journal-title">{{ $journal->title }}</span> Settings</h1>

    @if (!$journal->active)
        <alert level="primary" :dismissible="false">
            <h4>This journal has been archived.</h4>
            <p>Archived journals are "sealed" and can no longer be written in. They are also removed from rotation, which means everyone in the journal can read it anytime.</p>
        </alert>
    @endif

    <journal-card
        class="d-md-none mt-3"
        read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
        write-url="{{ Auth::user()->can('addEntry', $journal) ? route('journal.show', $journal) : '' }}"
        settings-url="{{ Auth::user()->can('viewSettings', $journal) ? route('journal.settings', $journal) : '' }}"
        image-url="{{ Storage::url($journal->image_path) }}"
        queue-json="{{ $journal->queue }}"
    ></journal-card>

    @can('update', $journal)
        <div class="card my-5">
            <h2 class="card-header">Journal settings</h2>
            <div class="card-body">
                <form id="update-form" method="post" action="{{ route('journal.update', $journal) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="journal-title form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ $errors->has('title') ? old('title') : $journal->title }}">
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="font-italic form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="description" name="description" value="{{ $errors->has('description') ? old('description') : $journal->description }}">
                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    @if ($journal->has_custom_image)
                        <div class="form-group">
                            <label class="mr-3">Remove the uploaded cover image?</label>
                            <label class="rocker align-middle">
                                <input type="checkbox" id="remove_image" name="remove_image">
                                <span class="switch-left">Yes</span>
                                <span class="switch-right expect">No</span>
                            </label>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="cover_image">Upload a new cover image:
                            <help-icon
                                text="Images should be under 2MB"
                                class="ml-1"
                            ></help-icon>
                        </label>
                        <file-input
                            errors-json="{{ $errors }}"
                            name="cover_image"
                            id="cover_image"
                            initial-placeholder="Choose a file"
                        ></file-input>
                    </div>

                    <div class="form-group">
                        <label for="period">How often should this journal rotate?</label>
                        <select id="period" name="period" class="custom-select" required {{ $journal->active ? '' : 'disabled' }}>
                            <option value="{{ App\Journal::EVERY_DAY }}" {{ $journal->period == App\Journal::EVERY_DAY ? 'selected' : '' }}>Every day</option>
                            <option value="{{ App\Journal::EVERY_WEEK }}" {{ $journal->period == App\Journal::EVERY_WEEK ? 'selected' : '' }}>Every week</option>
                            <option value="{{ App\Journal::EVERY_TWO_WEEKS }}" {{ $journal->period == App\Journal::EVERY_TWO_WEEKS ? 'selected' : '' }}>Every two weeks</option>
                            <option value="{{ App\Journal::EVERY_THREE_WEEKS }}" {{ $journal->period == App\Journal::EVERY_THREE_WEEKS ? 'selected' : '' }}>Every three weeks</option>
                            <option value="{{ App\Journal::EVERY_FOUR_WEEKS }}" {{ $journal->period == App\Journal::EVERY_FOUR_WEEKS ? 'selected' : '' }}>Every four weeks</option>
                        </select>
                        @if ($errors->has('period'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('period') }}</strong>
                            </span>
                        @endif
                        @if(!$journal->active)
                            <span class="text-danger">
                                <strong>This setting can't be changed because this journal has been archived.</strong>
                            </span>
                        @endif
                    </div>

                </form>
            </div>
            <button type="submit" form="update-form" class="btn btn-block btn-primary">Save Journal Settings</button>
        </div>
    @endcan

    <participant-settings-card
        auth-user-json="{{ Auth::user() }}"
        users-json="{{ $journal->queue->count() ? $journal->queue : $journal->users }}"
        queue-url="{{ route('api.journal.updateQueue', $journal) }}"
    ></participant-settings-card>

    <invite-settings-card
        auth-user-json="{{ Auth::user() }}"
        :auth-user-can-invite="{{ Auth::user()->can('invite', $journal) ? 'true' : 'false' }}"
        invites-json="{{ $journal->invites }}"
        invite-url="{{ route('journal.invite', $journal) }}"
        verification-resend-url="{{ route('verification.resend') }}"
        errors-json="{{ $errors }}"
        old-name="{{ old('name') }}"
        old-email="{{ old('email') }}"
        csrf="{{ csrf_token() }}"
    ></invite-settings-card>

    @can('archive', $journal)
        <div class="card mb-5">
            <h2 class="card-header">{{ $journal->active ? 'Archive' : 'Unarchive' }} this journal</h2>
            <div class="card-body">
                @if ($journal->active)
                    <p>Archived journals are "sealed" and can no longer be written in. Entries can't be added or edited, nor can new comments be posted. They are also removed from rotation, which means everyone in the journal will be able to read it anytime.</p>
                    <p><strong>Consider informing the other participants of this journal before archiving it.</strong></p>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#archive-confirm">
                        <font-awesome-icon icon="archive"></font-awesome-icon>
                        <span class="ml-2">Archive this journal</span>
                    </button>

                    <modal modal-id="archive-confirm">
                        <template slot="title">Are you sure you want to archive this journal?</template>
                        <p>This will remove the journal from the current user's possession <strong>without</strong> posting any of their draft entries.</p>
                        <p>You may want to give a heads up to the other participants in this journal first!</p>
                        <template slot="footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                            <form class="d-inline" method="post" action="{{ route('journal.archive', $journal) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">Yes, archive</button>
                            </form>
                        </template>
                    </modal>
                @else
                    <p>Unarchive this journal to put it back into rotation. You will be the first person to have it, and the rotation will proceed according to the queue.</p>
                    <form class="d-inline" method="post" action="{{ route('journal.archive', $journal) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-dark">Unarchive this journal</button>
                    </form>
                @endif
            </div>
        </div>
    @endcan

</div>
@endsection
