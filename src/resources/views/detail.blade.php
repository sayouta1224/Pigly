<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>情報更新ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
</head>

<body>
    @include('layouts.header')
    <main class="main-contents">
        <div class="detail-content">
            <div class="detail-content__inner">
                <div class="content__heading">Weight Log
                </div>
                <form action="/weight_logs/{weight_log_id}/update" method="post">
                    @csrf
                    <div class="detail-form__items">
                        <label class="detail-form__label" for="date" name="date">日付</label><span class="required">必須</span>
                        <input class="detail-form__input date" type="date" name="date" value="{{ date('Y-m-d') }}">
                        <p class="error-message">
                            @error('date')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="detail-form__items">
                        <label class="detail-form__label" for="weight" name="weight">体重</label><span class="required">必須</span>
                        <input class="detail-form__input detail-weight" type="" name="weight" value="{{$weight_log->weight}}"><span class="detail-unit">kg</span>
                        <p class="error-message">
                            @error('weight')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="detail-form__items">
                        <label class="detail-form__label" for="calories" name="calories">摂取カロリー</label><span class="required">必須</span>
                        <input class="detail-form__input detail-calories" type="" name="calories" value="{{$weight_log->calories}}"><span class="detail-unit">cal</span>
                        <p class="error-message">
                            @error('calories')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="detail-form__items">
                        <label class="detail-form__label" for="exercise_time" name="exercise_time">運動時間</label><span class="required">必須</span>
                        <input class="detail-form__input detail-time" type="time"  name="exercise_time" value="{{substr($weight_log->exercise_time, 0, 5)}}">
                        <p class="error-message">
                            @error('exercise_time')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="detail-form__items">
                        <label class="detail-form__label" for="exercise_content" name="exercise_content">運動内容</label>
                        <textarea class="textarea" name="exercise_content" id="" placeholder="運動内容を追加">{{$weight_log->exercise_content}}</textarea>
                        <p class="error-message">
                            @error('exercise_content')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>

                    <div class="detail-form__actions">
                        <a href="/weight_logs" class="back-btn">戻る</a>
                        <button class="detail-form__update-btn btn" type="submit">更新</button>
                        <div class="trash-can-content">
                            <a href="/weight_logs/{{$weight_log->id}}/delete">
                                <img src="{{ asset('images/ゴミ箱のアイコン素材 1.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <input type="hidden" name="weight_log_id" class="weight_log_id" id="weight_log_id" value="{{ $weight_log->id }}">
                </form>
            </div>
        </div>
    </main>
</body>

</html>