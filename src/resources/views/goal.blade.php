<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>目標体重変更ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/goal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
</head>

<body>
    @include('layouts.header')
    <main class="main-contents">
        <div class="goal-content">
            <div class="goal-content__inner">
                <div class="content__heading" for="target__weight">目標体重設定</div>
                <form action="/weight_logs/goal_setting" method="post">
                    @csrf
                    <div class="goal-form__items">
                        <input class="goal-form__input" type="text" name="target_weight"><span class="goal-unit">kg</span>
                        <p class="error-message">
                            @error('target_weight')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="goal-form__actions">
                        <a href="/weight_logs" class="back-btn">戻る</a>
                        <input class="goal-form__send-btn btn" type="submit" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>