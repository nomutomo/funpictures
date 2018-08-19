@if ($user->image_path)
    @if ($size <140 )
        <img class="media-object img-rounded" src="{{ asset('storage/avatar/' . $user->id . '/' . $user->image_path) }}" height="{{ $size }}px" alt="">
    @else
        <img class="media-object img-rounded img-responsive" src="{{ asset('storage/avatar/' . $user->id . '/' . $user->image_path) }}" height="{{ $size }}px" alt="">
    @endif
@else
    @if ($size <140 )
        <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, $size) }}" alt="avatar" >
    @else
        <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, $size) }}" alt="avatar" >
    @endif
@endif