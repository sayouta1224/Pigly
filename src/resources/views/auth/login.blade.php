@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('form')
<h2 class="form__heading">ログイン</h2>
<div class="login-form__inner">
    <form class="login-form__form" action="/login" method="post">
        @csrf
        <div class="login-form__group">
            <label class="login-form__label" for="email">メールアドレス</label>
            <input class="login-form__input" type="mail" name="email" id="email" placeholder="メールアドレスを入力">
            <p class="error-message">
                @error('email')
                {{ $message }}
                @enderror
            </p>
        </div>
        <div class="login-form__group">
            <label class="login-form__label" for="password">パスワード</label>
            <input class="login-form__input" type="password" name="password" id="password" placeholder="パスワードを入力">
            <p class="error-message">
                @error('password')
                {{ $message }}
                @enderror
            </p>
        </div>
        <input class="login-form__btn btn" type="submit" value="ログイン">
        <a href="/register/step1" class="change">アカウント作成はこちら</a>
    </form>
</div>
@endsection