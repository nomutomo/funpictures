<ul id="sortable1" class="media-list droptrue col-xs-12">
    @foreach ($messages as $message)
        <?php $user = $message->user; ?>
        <li class="media">
            <div class="media-left">
                 @include('commons.avatar', ['size' => 25, 'user'=>$user])
            </div>
            <div class="media-body">
                <div>
                    {!! $user->name !!} <span class="text-muted"> - {{ $message->created_at }}</span>
                </div>
                <div>
                    @if (isset($message->image_path))
                        <p><img class="media-object img-rounded img-responsive" src="{{ asset('storage/avatar/' . $user->id . '/' . $message->image_path) }}" alt="avater"></p>
                    @endif
                    <p>{!! nl2br(e($message->content)) !!}</p>
                </div>
            </div>
        </li>
    @endforeach
</ul>
<ul class="col-xs-12">
    {!! $messages->render() !!}
</ul>