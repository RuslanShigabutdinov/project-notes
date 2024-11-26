@extends('layouts.main')
 
@section('title', 'Project Notes')
 
@section('cssLinks')
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
    <link rel="stylesheet" href="{{url('css/dropdown.css')}}">
    <link rel="stylesheet" href="{{url('css/cards.css')}}">
    <link rel="stylesheet" href="{{url('css/modal.css')}}">

@endsection
 
@section('content')
    <a href="#friend-modal">Добавить друга</a>
    @if ($friendRequests->count() > 0)
        <div style="background-color: rgba(160, 255, 141, 0.918)">
            <p>Запрос на дружбу:</p>
            @foreach ($friendRequests as $friend)
                <p style="margin: 15px 0 0 0">{{ $friend->name }}</p>
                <p style="margin: 0px">{{ $friend->email }}</p>
                <a href="/friend/{{ $friend->email }}/accept">Принять</a>
                <a href="/friend{{ $friend->email }}/decline">Отклонить</a>
            @endforeach
        </div>
    @endif
    @if ($pendingFriends->count() > 0)
        <div style="background-color: rgba(255, 255, 255, 0.918)">
            <p>Запрос на добавление:</p>
            @foreach ($pendingFriends as $friend)
                <p style="margin: 15px 0 0 0">{{ $friend->name }}</p>
                <p style="margin: 0px">{{ $friend->email }}</p>
            @endforeach
        </div>
    @endif
    @if ($acceptedFriends->count() > 0)
        <div style="background-color: rgba(92, 252, 60, 0.918)">
            <p>Друзья:</p>
            @foreach ($acceptedFriends as $friend)
                <p style="margin: 15px 0 0 0">{{ $friend->name }}</p>
                <p style="margin: 0px">{{ $friend->email }}</p>
            @endforeach
        </div>
    @endif
    @if ($rejectedFriends->count() > 0)
        <div style="background-color: rgba(255, 99, 99, 0.918)">
            <p>Отклоненные запросы:</p>
            @foreach ($acceptedFriends as $friend)
                <p style="margin: 15px 0 0 0">{{ $friend->name }}</p>
                <p style="margin: 0px">{{ $friend->email }}</p>
            @endforeach
        </div>
    @endif
    @if ($blockedFriends->count() > 0)
        <div style="background-color: rgba(32, 1, 1, 0.918); color:rgb(255, 255, 255)">
            <p>Заблокированные:</p>
            @foreach ($acceptedFriends as $friend)
                <p style="margin: 15px 0 0 0">{{ $friend->name }}</p>
                <p style="margin: 0px">{{ $friend->email }}</p>
            @endforeach
        </div>
    @endif
    <div id="friend-modal" class="modal">
        <div class="modal__content">
            <form action="/friend/add" method="post">
                @csrf
                <h2>Напиши почту друга</h2>
                <input type="email" name="email" placeholder="Email">
                <button type="submit">Отправить запрос</button>
            </form>
            <a href="#" class="modal__close">&times;</a>
        </div>
    </div>
@endsection