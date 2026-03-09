<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل حساب جديد</title>
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
        .register-container {
            background: #ecf0f3;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 5px 5px 10px #babecc, -5px -5px 10px #ffffff;
            text-align: center;
            width: 320px;
        }
        .register-container h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .register-container input, .register-container select {
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
        .register-container input:focus, .register-container select:focus {
            box-shadow: inset 1px 1px 2px #babecc, inset -1px -1px 2px #ffffff;
        }
        .register-container button {
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
        .register-container button:hover {
            background: linear-gradient(145deg, #0056b3, #003f7f);
        }
        .register-container p {
            margin-top: 15px;
            font-size: 14px;
        }
        .register-container a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .register-container a:hover {
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
    <div class="register-container">
        <h2>📝 تسجيل حساب جديد</h2>

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="👤 الاسم الكامل" value="{{ old('name') }}" required>
            <input type="email" name="email" placeholder="📧 البريد الإلكتروني" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="🔑 كلمة المرور" required>
            <input type="password" name="password_confirmation" placeholder="🔒 تأكيد كلمة المرور" required>
            <label>⚡ الدور:</label>
            <select name="role" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👑 مدير</option>
                <option value="engineer" {{ old('role') == 'engineer' ? 'selected' : '' }}>🛠️ مهندس</option>
                <option value="secretary" {{ old('role') == 'secretary' ? 'selected' : '' }}>📑 سكرتير</option>
                <option value="accountant" {{ old('role') == 'accountant' ? 'selected' : '' }}>💰 محاسب</option>
            </select>
            <button type="submit">🚀 إنشاء الحساب</button>
        </form>

        <p>لديك حساب بالفعل؟ <a href="{{ route('home') }}">➡️ تسجيل الدخول</a></p>
    </div>
</body>
</html>