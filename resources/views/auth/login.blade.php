<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        body {
            background: #ecf0f3;
            font-family: "Tajawal", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #ecf0f3;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 5px 5px 10px #babecc, -5px -5px 10px #ffffff;
            text-align: center;
            width: 300px;
        }
        .login-container h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            background: #f0f0f0;
            box-shadow: inset 3px 3px 6px #d1d9e6, inset -3px -3px 6px #ffffff;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }
        .login-container input:focus {
            box-shadow: inset 1px 1px 2px #babecc, inset -1px -1px 2px #ffffff;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(145deg, #007bff, #0056b3);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-container button:hover {
            background: linear-gradient(145deg, #0056b3, #003f7f);
        }
        .login-container p {
            margin-top: 15px;
            font-size: 14px;
        }
        .login-container a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .login-container a:hover {
            color: #0056b3;
        }
        .error-messages {
            background: #ffe6e6;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            color: #d32f2f;
            font-size: 14px;
            box-shadow: 3px 3px 6px #babecc;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔑 تسجيل الدخول</h2>

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="📧 البريد الإلكتروني" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="🔒 كلمة المرور" required>
            <button type="submit">🚀 تسجيل الدخول</button>
        </form>

       
    </div>
</body>
</html>