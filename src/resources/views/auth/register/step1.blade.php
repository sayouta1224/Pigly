@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register_1.css') }}">
@endsection

@section('form')
<h2 class="form__heading">新規会員登録</h2>
<h3 class="register-form__heading">STEP1 アカウント情報の登録</h3>
<div class="register-form__inner">
    <form class="register-form__form" action="/register/step1" method="post">
        @csrf
        <div class="register-form__group">
            <label class="register-form__label" for="name">お名前</label>
            <input class="register-form__input" type="text" name="name" id="name" placeholder="名前を入力">
            <p class="error-message">
                @error('name')
                {{ $message }}
                @enderror
            </p>
        </div>
        <div class="register-form__group">
            <label class="register-form__label" for="email">メールアドレス</label>
            <input class="register-form__input" type="mail" name="email" id="email" placeholder="メールアドレスを入力">
            <p class="error-message">
                @error('email')
                {{ $message }}
                @enderror
            </p>
        </div>
        <div class="register-form__group">
            <label class="register-form__label" for="password">パスワード</label>
            <input class="register-form__input" type="password" name="password" id="password" placeholder="パスワードを入力">
            <p class="error-message">
                @error('password')
                {{ $message }}
                @enderror
            </p>
        </div>
        <input class="register-form__btn btn" type="submit" value="次に進む">
        <a href="/login" class="change">ログインはこちら</a>
    </form>
</div>
@endsection