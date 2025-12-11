@foreach($comments as $comment)
    <div class="single-comment" id="comment-{{ $comment->id }}" style="padding-top: 10px; margin-bottom: 10px;">
        
        <div class="comment-meta">
            <span class="comment-author" style="color: #06b6d4; font-weight: 600;">{{ $comment->user->name }}</span>
            <span class="comment-date" style="color: #64748b; font-size: 11px;"> • {{ $comment->created_at->diffForHumans() }}</span>
        </div>

        <p class="comment-text" style="color: #cbd5e1; margin: 5px 0; font-size: 14px;">{{ $comment->content }}</p>

        <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 10px;">
            
            @php
                // Cek Vote User saat ini untuk komentar ini
                $userVote = Auth::check() ? $comment->votes->where('user_id', Auth::id())->first() : null;
                $voteVal = $userVote ? $userVote->value : 0;
            @endphp

            {{-- LOGIC TAMPILAN VOTE --}}
            @if($thread->type == 'topic') 
                <div style="display: flex; align-items: center; background: rgba(255,255,255,0.05); border-radius: 4px; padding: 2px 5px;">
                    {{-- UPVOTE --}}
                    <form action="{{ route('vote') }}" method="POST">@csrf
                        <input type="hidden" name="votable_id" value="{{ $comment->id }}"><input type="hidden" name="votable_type" value="comment"><input type="hidden" name="value" value="1">
                        <button class="btn-vote-sm" style="color: {{ $voteVal==1 ? '#f97316' : '#94a3b8' }};">
                            <ion-icon name="caret-up"></ion-icon>
                        </button>
                    </form>
                    
                    <span style="font-size: 12px; font-weight: bold; margin: 0 5px; color: {{ $voteVal==1 ? '#f97316' : ($voteVal==-1 ? '#3b82f6' : '#cbd5e1') }}">
                        {{ $comment->score }}
                    </span>

                    {{-- DOWNVOTE --}}
                    <form action="{{ route('vote') }}" method="POST">@csrf
                        <input type="hidden" name="votable_id" value="{{ $comment->id }}"><input type="hidden" name="votable_type" value="comment"><input type="hidden" name="value" value="-1">
                        <button class="btn-vote-sm" style="color: {{ $voteVal==-1 ? '#3b82f6' : '#94a3b8' }};">
                            <ion-icon name="caret-down"></ion-icon>
                        </button>
                    </form>
                </div>

            @else
                <form action="{{ route('vote') }}" method="POST">@csrf
                    <input type="hidden" name="votable_id" value="{{ $comment->id }}"><input type="hidden" name="votable_type" value="comment"><input type="hidden" name="value" value="1">
                    <button class="btn-vote-sm" style="color: {{ $voteVal==1 ? '#f43f5e' : '#94a3b8' }};">
                        <ion-icon name="{{ $voteVal==1 ? 'heart' : 'heart-outline' }}"></ion-icon> 
                        {{ $comment->score }} Like
                    </button>
                </form>
            @endif

            <button onclick="toggleReplyForm({{ $comment->id }})" class="btn-vote-sm" style="color: #94a3b8;">
                <ion-icon name="chatbox-ellipses-outline"></ion-icon> Reply
            </button>
        </div>

        <div id="reply-form-{{ $comment->id }}" style="display: none; margin-top: 10px;">
            <form action="{{ route('comment.store', $thread->id) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" rows="2" class="comment-input" style="font-size: 13px; width: 100%;" placeholder="Balas komentar {{ $comment->user->name }}..."></textarea>
                <button type="submit" class="btn-submit-comment" style="padding: 5px 15px; font-size: 12px; margin-top: 5px;">Kirim</button>
            </form>
        </div>

        @if($comment->replies->count() > 0)
            <div class="nested-comment">
                {{-- Di sini kita memanggil file ini lagi (RECURSION) --}}
                @include('partials.comment-item', ['comments' => $comment->replies])
            </div>
        @endif

    </div>
@endforeach