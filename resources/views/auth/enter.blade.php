@extends('layouts.auth')
@section('content')
    <div class="forms-container">
        <div class="signin-signup">
            <form autocomplete="off" action="{{route('login')}}" method="post" class="sign-in-form">
                @csrf
                <h2 class="title">Вход</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Логин" name="login"/>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Пароль" name="password"/>
                </div>
                <!--            <span>-->
                <!--            <i class="fa fa-snowflake fa-spin"></i>-->
                <!--            <input type="submit" value="Войти" class="btn solid" />-->
                <button type="submit" class="btn solid">
                    <i class="fas fa-spinner fa-spin del"></i><span class="text">Войти</span>
                </button>
                <!--                </span>-->
                <a class="social-text" href="#">Забыли пароль?</a>
                <div class="brand-container"><a href="{{route('main')}}" class="brand">Мой блог</a></div>
            </form>
            <form autocomplete="off" action="{{route('register',(isset($user->id))?$user->login:'')}}"
                  method="post" class="sign-up-form registration">
                @csrf
                <h2 class="title">Регистрация</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Логин" name="login"/>
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email" name="email"/>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Пароль" name="password"/>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Повторите пароль" name="password_confirmation"/>
                </div>
                <button type="submit" class="btn solid long">
                    <i class="fas fa-spinner fa-spin del"></i><span class="text">Зарегистрироваться</span>
                </button>
                <!--            <input type="submit" class="btn solid long" value="Зарегистрироваться" />-->
                <div class="brand-container"><a href="{{route('main')}}" class="brand">Мой блог</a></div>
            </form>
            <form autocomplete="off" action="{{route('recovery')}}" method="post" class="sign-up-form reset hidden">
                @csrf
                <h2 class="title">Восстановление доступа</h2>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email" name="email"/>
                </div>
                <button type="submit" class="btn solid">
                    <i class="fas fa-spinner fa-spin del"></i><span class="text">Отправить</span>
                </button>
                <!--            <input type="submit" class="btn solid" value="Отправить" />-->
                <div class="brand-container"><a href="{{route('main')}}" class="brand">Мой блог</a></div>
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                @if (isset($user->id))
                    <h3>Приглашение</h3>
                    <p>
                        Зарегистрируйтесь на сайте по ссылке от: {{$user->login}}
                    </p>
                @else
                    @if(isset($error))
                        <h3>{{$error}}</h3>
                    @else
                        <h3>Впервые здесь ?</h3>
                    @endif
                    <p>
                        Зарегистрируйтесь, чтобы получить возможность оставлять комментарии на сайте
                    </p>
                @endif
                <button class="btn transparent" id="sign-up-btn">
                    Регистрация
                </button>
            </div>
            <img src="{{asset('images/auth/log.svg')}}" class="image" alt=""/>
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
            <img src="{{asset('images/auth/register.svg')}}" class="image" alt=""/>
        </div>
    </div>
@endsection
