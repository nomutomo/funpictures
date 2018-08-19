<ul class="media-list">
    @foreach ($messages as $message)
        <?php 
            $user = $message->user;
        ?>
        <li class="media">
            <div class="media-left">
                 @include('commons.avatar', ['size' => 25, 'user'=>$user])
            </div>
            <div class="media-body">
                <div>
                    {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted"> - {{ $message->created_at }}</span>
                </div>
                <div>
                    @if (isset($message->image_path))
                        <p><img class="media-object img-rounded" src="{{ asset('storage/avatar/' . $user->id . '/' . $message->image_path) }}" height="200px" alt="avater"/></p>
                    @endif
                    <p>{!! nl2br(e($message->content)) !!}</p>
                </div>
                <div>
                    @if (Auth::id() == $message->user_id)
                        {!! Form::open(['route' => ['messages.destroy',$message->id], 'method' => 'delete']) !!}
                            {!! Form::hidden('image_path',$message->image_path) !!}
                            {!! Form::submit('削除', ['class' => 'btn btn-danger btn-xs']) !!}
                         {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
{!! $messages->render() !!}