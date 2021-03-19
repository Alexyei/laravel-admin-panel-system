@extends('layouts.auth')
@section('title','Регистрация завершена')
@section('content')

<div class="forms-container">
    <div class="signin-signup">
        <form autocomplete="off" action="{{route('login')}}" method="post" class="sign-in-form">
            @csrf
            <h2 class="title">Вход</h2>
            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Логин" name="login" value="{{$login}}"/>
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Пароль" name="password"/>
            </div>
            <!--            <input type="submit" value="Войти" class="btn solid" />-->
            <button type="submit" class="btn solid">
                <i class="fas fa-spinner fa-spin del"></i><span class="text">Войти</span>
            </button>
            <div class="brand-container"><a href="{{route('main')}}" class="brand">Мой блог</a></div>
        </form>

    </div>
</div>

<div class="panels-container">
    <div class="panel left-panel">
        <div class="content">
            <h3>Пароль сброшен</h3>
            <p>
                Новый пароль: {{$password}}
            </p>
        </div>
        <img src="{{asset('images/auth/log.svg')}}" class="image" alt="" />
    </div>
    <div class="panel right-panel">
        <div class="content">
            <h3>Один из нас ?</h3>
            <p>
                Войдите в свою учётную запись
            </p>
            <button class="btn transparent" id="sign-in-btn">
                Вход
            </button>
        </div>
        <img src="{{asset('images/auth/register.svg')}}" class="image" alt="" />
    </div>
</div>
@endsection
