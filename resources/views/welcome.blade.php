@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="row">
            <aside class="col-xs-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $user->name }}</h3>
                    </div>
                    <div class="panel-body">
                        @include('commons.avatar', ['size' => 500, 'user' => $user])
                    </div>
                    <div class="panel-body">
                        {{ $user->profile }}
                    </div>
                </div>
            </aside>
            <div class="col-xs-9">
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
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>ようこそ! Fun! Picturesへ!!</h1>
                {!! link_to_route('signup.get', 'サインアップ', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection