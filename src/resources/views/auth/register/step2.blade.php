@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register_2.css')}}">
@endsection

@section('form')
<h2 class="form__heading">新規会員登録</h2>
<h3 class="register-form__heading">STEP2 体重データの入力</h3>
<div class="register-form__inner">
    <form class="register-form__form" action="/register/step2" method="post">
        @csrf
        <div class="register-form__group">
            <label class="register-form__label" for="now_weight">現在の体重</label>
            <input class="register-form__input" type="text" name="now_weight" id="now_weight" step="0.1" placeholder="現在の体重を入力"><span class="register-unit">kg</span>
            <p class="error-message">
                @error('now_weight')
                {{ $message }}
                @enderror
            </p>
        </div>
        <div class="register-form__group">
            <label class="register-form__label" for="target_weight">目標の体重</label>
            <input class="register-form__input" type="text" name="target_weight" id="target_weight" step="0.1" placeholder="目標の体重を入力"><span class="register-unit">kg</span>
            <p class="error-message">
                @error('target_weight')
                {{ $message }}
                @enderror
            </p>
        </div>
        <input class="register-form__btn btn" type="submit" value="アカウント作成">
    </form>
</div>
@endsection