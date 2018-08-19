@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->name }}</h3>
                </div>
                <div class="panel-body">
                        @include('commons.avatar', ['size' => 500, 'user'=>$user])
                </div>
                <div class="panel-body">
                    {{ $user->profile }}
                </div>
            </div>
            @include('user_follow.follow_button', ['user' => $user])
        </aside>
        <div class="col-xs-9">
            <ul class="nav nav-tabs nav-justified">
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a href="{{ route('users.show', ['id' => $user->id]) }}">タイムライン <span class="badge">{{ $count_messages }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/pickups') ? 'active' : '' }}"><a href="{{ route('users.pickups', ['id' => $user->id]) }}">ピックアップ <span class="badge">{{ $count_pickups }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}"><a href="{{ route('users.followings', ['id' => $user->id]) }}">フォロー <span class="badge">{{ $count_followings }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('users.followers', ['id' => $user->id]) }}">フォロワー <span class="badge">{{ $count_followers }}</span></a></li>
            </ul>
            <p></p>
            @if (Auth::id() == $user->id)
                {!! Form::model(Auth::user(), ['route' => ['messages.put'], 'method' => 'post','files' => true]) !!}
                    <div class="form-group">
                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2']) !!}
                        {!! Form::label('file', '画像を選択', ['class' => 'control-label']) !!}
                        {!! Form::file('file',old('file'), ['class' => 'form-control']) !!}
                        {!! Form::submit('投稿', ['class' => 'btn btn-primary btn-block']) !!}
                    </div>
                {!! Form::close() !!}
            @endif
            @if (count($messages) > 0)
                @include('messages.messages', ['messages' => $messages])
            @endif
        </div>
    </div>
@endsection
