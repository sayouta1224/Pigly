<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>体重管理ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
    <script>
        // JavaScriptで日付フォーマットを変更
        function formatDate() {
            const dateInput = document.getElementById('date-input');
            const display = document.getElementById('formatted-date');

            // 入力された日付を取得
            const selectedDate = new Date(dateInput.value);

            if (!isNaN(selectedDate)) { // 有効な日付か確認
                const year = selectedDate.getFullYear().toString().slice(4); // yyyy形式
                const month = String(selectedDate.getMonth() + 1).padStart(2, '0'); // mm形式
                const day = String(selectedDate.getDate()).padStart(2, '0'); // dd形式

                // フォーマットして表示
                display.textContent = `${year}年${month}月${day}日`;
            } else {
                display.textContent = '無効な日付です';
            }
        }
    </script>
</head>

<body>
    @include('layouts.header')
    <main class="main-contents">
        <div class="top-contents">
            <div class="top-contents__inner">
                <div class="contents__items items-left">
                    <label class="weight-label" for="target__weight">
                        目標体重
                    </label>
                    <input class="target__weight-input weight-input" type="text" name="target__weight" value="{{$latestTargetWeight}}"><span class="unit">kg</span>
                </div>
                <div class="contents__items items-middle">
                    <label class="weight-label" for="down__weight">
                        目標まで
                    </label>
                    <input class="down__weight-input weight-input" type="text" name="down__weight" value="-{{$downWeight}}"><span class="unit">kg</span>
                </div>
                <div class="contents__items items-right">
                    <label class="weight-label" for="weight">
                        最新体重
                    </label>
                    <input class="weight-input" type="text" name="weight" value="{{$latestWeight}}"><span class="unit last-unit">kg</span>
                </div>
            </div>
        </div>
        <div class="bottom-contents">
            <div class="bottom-contents__inner">
                <div class="search-items">
                    <form class="search-form" action="/weight_logs/search" method="get">
                        @csrf
                        <div class="search-form__date">
                            <input class="from-date date" type="date" name="from" value="" onchange="formatDate()">
                            <span class="gap">～</span>
                            <input class="until-date date" type="date" name="until" value="" onchange="formatDate()">
                        </div>
                        @if(@isset($count)&& $count !="")
                        <p class="search__result">{{ $from }}~{{ $until }}の検索結果{{ $count }}件</p>
                        @endif
                        <div class="search-form__actions">
                            <input class="search-btn" type="submit" value="検索">
                            @if(@isset($count)&& $count !="")
                            <input class="reset-btn" type="submit" value="リセット" name="reset">
                            @endif
                        </div>
                    </form>
                </div>

                <a class="add-btn btn" href="#log-add">データ追加</a>

                <table class="log__table">
                    <tr class="log__row label-row">
                        <th class="log__label date-label">日付</th>
                        <th class="log__label">体重</th>
                        <th class="log__label">食事摂取カロリー</th>
                        <th class="log__label">運動時間</th>
                        <th class="log__label"></th>
                    </tr>
                    @foreach($weight_logs as $weight_log)
                    <tr class="log__row">
                        <td class="log__data date-data">{{date('Y/m/d', strtotime($weight_log->date))}}</td>
                        <td class="log__data weight-data">{{$weight_log->weight}}kg</td>
                        <td class="log__data calories-data">{{$weight_log->calories}}cal</td>
                        <td class="log__data exercise-data">{{substr($weight_log->exercise_time, 0, 5)}}</td>
                        <td class="log__data">
                            <a class="log__detail-btn" href="/weight_logs/{{$weight_log->id}}">
                                <img src="{{ asset('images/定番ペンのフリーアイコン素材 1.png') }}" alt="">
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="pagination-content">
                {{ $weight_logs->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>

                <div class="modal" id="log-add">
                    <a href="#!" class="modal-overlay"></a>
                    <div class="modal__inner">
                        <div class="modal__content">
                            <div class="modal__heading">Weight Logを追加</div>
                            <form class="modal__create-form" action="/weight_logs/create" method="post">
                                @csrf
                                <div class="modal-form__group">
                                    <label class="modal-form__label" for="">日付</label><span class="required">必須</span>
                                    <input class="modal-form__input date modal-date" type="date" name="date" id="date" value="{{ date('Y-m-d') }}">
                                    <p class="error-message">
                                        @error('date')
                                        {{ $message }}
                                        @enderror
                                    </p>
                                </div>

                                <div class="modal-form__group">
                                    <label class="modal-form__label" for="">体重</label><span class="required">必須</span>
                                    <input class="modal-form__input modal-weight" type="text" name="weight" placeholder="50.0"><span class="modal-unit">kg</span>
                                    <p class="error-message">
                                        @error('weight')
                                        {{ $message }}
                                        @enderror
                                    </p>
                                </div>

                                <div class="modal-form__group">
                                    <label class="modal-form__label" for="">摂取カロリー</label><span class="required">必須</span>
                                    <input class="modal-form__input modal-calories" type="text" name="calories"  placeholder="1200"><span class="modal-unit">cal</span>
                                    <p class="error-message">
                                        @error('calories')
                                        {{ $message }}
                                        @enderror
                                    </p>
                                </div>

                                <div class="modal-form__group">
                                    <label class="modal-form__label" for="">運動時間</label><span class="required">必須</span>
                                    <input class="modal-form__input modal-time" type="time" name="exercise_time" id="exercise_time" placeholder="0000">
                                    <p class="error-message">
                                        @error('exercise_time')
                                        {{ $message }}
                                        @enderror
                                    </p>
                                </div>

                                <div class="modal-form__group">
                                    <label class="modal-form__label" for="">運動内容</label>
                                    <textarea class="textarea" name="exercise_content" id="" placeholder="運動内容を追加"></textarea>
                                    <p class="error-message">
                                        @error('exercise_content')
                                        {{ $message }}
                                        @enderror
                                    </p>
                                </div>

                                <div class="modal-form__actions">
                                    <a href="/weight_logs" class="back-btn">戻る</a>
                                    <input class="modal-form__send-btn btn" type="submit" value="登録">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
