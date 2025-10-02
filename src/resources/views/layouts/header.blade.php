<div class="header-contents">
    <h1 class="header-character">PiGLy</h1>
    <div class="link-contents">
        <a class="header__link target__link" href="/weight_logs/goal_setting">
            <img class="image" src="{{ asset('images/設定の歯車アイコン素材 1.png') }}" alt="">目標体重設定
        </a>
        <form action="/logout" method="post">
            @csrf
            <button class="header__link" type="submit">
                <img class="image" src="{{ asset('images/ログアウト・サインアウトのアイコン素材 4.png') }}" alt="">ログアウト
            </button>
        </form>
    </div>
</div>