<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            direction: rtl;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .stat-box {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            width: 30%;
            font-weight: bold;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .btn {
            background: royalblue;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-logout {
            background: #ff4444;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-logout:hover {
            background: #cc0000;
        }
        .notes {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .notes textarea, .chat-box {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            resize: vertical;
        }
        .chat-box {
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .chat-box img {
            width: 20px;
            margin-left: 5px;
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .users-table th, .users-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .users-table th {
            background: #007bff;
            color: white;
        }
        .users-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .action-btn {
            padding: 5px 10px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        .edit-btn {
            background: #28a745;
        }
        .delete-btn {
            background: #dc3545;
        }
        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
            }
            .stat-box {
                width: 100%;
                margin-bottom: 10px;
            }
            .notes {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- شريط علوي -->
    <div class="header">
        <h1>لوحة تحكم المدير</h1>
        <div>مرحبًا، {{ Auth::user()->name }}!</div>
    </div>

    <div class="container">
        <!-- عرض رسائل النجاح أو الخطأ -->
        @if (session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif

        <!-- إحصائيات سريعة -->
        <div class="stats">
            <div class="stat-box">عدد المشاريع : {{ $totalProjectsCount ?? 0  }}</div>
            <div class="stat-box">عدد المستخدمين: {{ $usersCount ?? 0 }}</div>
        </div>

        <!-- أزرار الإجراءات -->
        <div class="grid">
            <a href="{{ route('admin.received.projects') }}" class="btn">
                📂 عرض المشاريع المرسلة والمستلمة
            </a>
            <a href="{{ route('register') }}" class="btn">
                ➕ إنشاء حساب جديد
            </a>
            <a href="{{ route('accountant') }}" class="btn">
                📜 عرض سجل المعاملات
            </a>
        </div>

        <!-- الملاحظات والدردشة -->
        <div class="notes">
            <div class="chat-box">
                <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" alt="whatsapp">
                دردشة جماعية
            </div>
           
        </div>

        <!-- قائمة المستخدمين -->
        <table class="users-table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الدور</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users ?? [] as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <form action="{{ route('admin.users.edit', $user->id) }}" method="GET" style="display: inline;">
                                <button type="submit" class="action-btn edit-btn">تعديل</button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف {{ $user->name }}؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- زر تسجيل الخروج -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="button" class="btn-logout" onclick="confirmLogout()">🚪 تسجيل الخروج</button>
        </form>
    </div>

    <script>
        function confirmLogout() {
            if (confirm('هل أنت متأكد من تسجيل الخروج؟')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
</body>
</html>