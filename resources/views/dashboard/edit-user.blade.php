<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المستخدم</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            direction: rtl;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
            text-align: right;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-submit {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background: #218838;
        }
        .btn-back {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .btn-back:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>تعديل المستخدم</h2>
        @if (session('success'))
            <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="role">الدور</label>
                <select name="role" id="role" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مدير</option>
                    <option value="engineer" {{ $user->role == 'engineer' ? 'selected' : '' }}>مهندس</option>
                    <option value="secretary" {{ $user->role == 'secretary' ? 'selected' : '' }}>سكرتير</option>
                    <option value="accountant" {{ $user->role == 'accountant' ? 'selected' : '' }}>محاسب</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور (اتركه فارغًا إذا لم ترغب في التغيير)</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" id="password_confirmation">
            </div>
            <button type="submit" class="btn-submit">حفظ التعديلات</button>
        </form>
        <a href="{{ route('dashboard.dashboard') }}" class="btn-back">العودة إلى لوحة التحكم</a>
    </div>
</body>
</html>