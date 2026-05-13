<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход в систему</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Inter, Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 48%, #2563eb 100%);
            color: #172033;
        }
        .login-card {
            width: min(420px, calc(100vw - 28px));
            padding: 28px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 28px 70px rgba(15, 23, 42, .32);
        }
        h1 { margin: 0 0 8px; font-size: 26px; }
        p { margin: 0 0 22px; color: #64748b; }
        label {
            display: block;
            margin-bottom: 6px;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }
        input {
            width: 100%;
            min-height: 44px;
            margin-bottom: 14px;
            border: 1px solid #cfddf0;
            border-radius: 8px;
            padding: 10px 12px;
            font: inherit;
        }
        button {
            width: 100%;
            min-height: 44px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: #fff;
            font-weight: 900;
            cursor: pointer;
        }
        .remember {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 16px;
            color: #64748b;
            font-size: 14px;
            text-transform: none;
        }
        .remember input { width: auto; min-height: auto; margin: 0; }
        .errors {
            margin-bottom: 16px;
            padding: 12px;
            border: 1px solid #fecdca;
            border-radius: 8px;
            background: #fef3f2;
            color: #912018;
        }
    </style>
</head>
<body>
<main class="login-card">
    <h1>Вход в админ-панель</h1>
    <p>Система аренды повербанков</p>

    @if($errors->any())
        <div class="errors">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="post" action="{{ route('login.store') }}">
        @csrf
        <label>Email</label>
        <input name="email" type="email" value="{{ old('email', 'admin@example.com') }}" required autofocus>

        <label>Пароль</label>
        <input name="password" type="password" value="password" required>

        <label class="remember">
            <input name="remember" type="checkbox" value="1">
            Запомнить вход
        </label>

        <button>Войти</button>
    </form>
</main>
</body>
</html>
