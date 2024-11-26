<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="{{url('img/favicon.png')}}" />
    <link rel="stylesheet" href="{{url('css/alerts.css')}}">
    <title>@yield('title')</title>
    @yield('cssLinks')
    
</head>
<body>
    @if (\Session::has('success'))
        <label>
        <input type="checkbox" class="alertCheckbox ddbox" autocomplete="off" />
        <div class="alert notice">
            <span class="alertClose">X</span>
            <span class="alertText">{{ \Session::get('success') }}
            <br class="clear"/></span>
        </div>
        </label>
    @elseif(\Session::has('error'))
        <label>
        <input type="checkbox" class="alertCheckbox ddbox" autocomplete="off" />
        <div class="alert error">
            <span class="alertClose">X</span>
            <span class="alertText">{{ \Session::get('error') }}
            <br class="clear"/></span>
        </div>
        </label>
    @endif
    <header>
        <div class="flex">
            <div class="sec-center"> 	
                <input class="dropdown ddbox" type="checkbox" id="file-dropdown" name="dropdown"/>
                <label class="for-dropdown" for="file-dropdown">Заметки</label>
                <div class="section-dropdown"> 
                    <a href="/">Все заметки</a>
                    <a href="/note/create">Создать</a>
                    <a href="#">Dropdown Link</a>
                </div>
            </div>
            <div class="sec-center">
                @guest
                    <input class="dropdown ddbox" type="checkbox" id="user-dropdown" name="dropdown"/>
                    <label class="for-dropdown" for="user-dropdown">
                        <img src="img/avatar.png" style="height: 30px; padding-right:10px">User
                    </label>
                    <div class="section-dropdown">
                        <a href="#register-modal">Регистрация</a>
                        <a href="#login-modal">Логин</a>
                    </div>
                @else
                    @php
                        $user = Auth::user()
                    @endphp
                    <input class="dropdown ddbox" type="checkbox" id="user-dropdown" name="dropdown"/>
                    <label class="for-dropdown" for="user-dropdown">
                        <img src="{{url($user->avatar)}}" style="height: 30px; padding-right:10px">{{ $user->name }}
                    </label>
                    <div class="section-dropdown"> 
                        <a href="/">Профиль</a>
                        <a href="/friends">Список друзей</a>
                        <a href="/auth/logout">Выход</a>
                    </div>
                @endguest
            </div>
        </div>
    </header>
    <div class="background">
        <div class="main">
            @yield('content')
        </div>
    </div>
    <footer></footer>
    <div id="register-modal" class="modal">
        <div class="modal__content">
            <form action="/auth/register" method="post">
                @csrf
                <h2>Регистрация</h2>
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Пароль">
                <input type="password" name="password_confirmation" placeholder="Повторный пароль">
                <button type="submit">Зарегестрироваться</button>
            </form>
            <a href="#" class="modal__close">&times;</a>
        </div>
    </div>
    <div id="login-modal" class="modal">
        <div class="modal__content">
            <form action="/auth/login" method="post">
                @csrf
                <h2>Логин</h2>
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Пароль">
                <button type="submit">Логин</button>
            </form>
            <a href="#" class="modal__close">&times;</a>
        </div>
    </div>
    @yield('jsScripts')
</body>
</html>