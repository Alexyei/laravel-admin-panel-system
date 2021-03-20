@extends('layouts.auth')
@section('title','Кабинет')
@section('content')

    <div class="forms-container">
    <div class="signin-signup">

        <form autocomplete="off" action="{{route('cabinet.change')}}" method="post" class="sign-up-form registration">
            @csrf
            <h2 class="title">Изменить данные</h2>
            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Логин" name="login" value="{{auth()->user()->login}}"/>
            </div>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" name="email" value="{{auth()->user()->email}}"/>
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Новый пароль" name="password"/>
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Повторите пароль" name="password_confirmation"/>
            </div>
            <!--            <input type="submit" class="btn solid" value="Сохранить" />-->
            <button type="submit" class="btn solid">
                <i class="fas fa-spinner fa-spin del"></i><span class="text">Сохранить</span>
            </button>
            <div class="brand-container"><a href="{{route('main')}}" class="brand">Мой блог</a></div>
        </form>

    </div>
</div>

<div class="panels-container">
    <div class="panel left-panel hidden">
        <div class="content">
            <h3>Впервые здесь ?</h3>
            <p>
                Зарегистрируйтесь, чтобы получить возможность оставлять комментарии на сайте
            </p>
            <button class="btn transparent" id="sign-up-btn">
                Регистрация
            </button>
        </div>
        <img src="{{asset('images/auth/log.svg')}}" class="image" alt="" />
    </div>
    <div class="panel right-panel">
        <div class="content">

            <button class="btn transparent" id="sign-in-btn" onclick="window.location='{{route('logout')}}'">
                Выйти
            </button>
        </div>
        <img src="{{asset('images/auth/register.svg')}}" class="image" alt="" />
    </div>
</div>
@endsection
