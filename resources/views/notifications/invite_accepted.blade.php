<strong>{{ App\User::find($notification->data['user_id'])->name }}</strong> has accepted your invite to <a href="{{ route('journal.settings', $notification->data['journal_id']) }}"><strong>{{ App\Journal::find($notification->data['journal_id'])->title }}</strong></a>