<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل معاملة</title>
    <style>
        body {
            background: #ecf0f3;
            font-family: "Tajawal", sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            direction: rtl;
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
            max-width: 600px;
            margin: 20px auto;
            background: #ecf0f3;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 5px 5px 10px #babecc, -5px -5px 10px #ffffff;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: right;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #ecf0f3;
            box-shadow: inset 3px 3px 6px #d1d9e6, inset -3px -3px 6px #ffffff;
            font-size: 16px;
        }
        .form-control:focus {
            outline: none;
            box-shadow: inset 3px 3px 6px #babecc, inset -3px -3px 6px #ffffff;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(145deg, #007bff, #0056b3);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            transition: 0.3s;
            cursor: pointer;
            box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
        }
        .btn-submit:hover {
            background: linear-gradient(145deg, #0056b3, #007bff);
        }
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 12px;
            background: linear-gradient(145deg, #28a745, #218838);
            color: white;
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
            text-decoration: none;
        }
        .btn-back:hover {
            background: linear-gradient(145deg, #218838, #28a745);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✏️ تعديل معاملة</h1>
        <div>مرحبًا، {{ Auth::user()->name }}!</div>
    </div>

    <div class="container">
        <h2>تعديل المعاملة</h2>
        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="transaction_name">اسم المعاملة:</label>
                <input type="text" name="transaction_name" value="{{ $transaction->transaction_name }}" required class="form-control">
            </div>
            <div class="form-group">
                <label for="transaction_code">كود المعاملة:</label>
                <input type="text" name="transaction_code" value="{{ $transaction->transaction_code }}" required class="form-control">
            </div>
            <div class="form-group">
                <label for="client_name">اسم العميل:</label>
                <input type="text" name="client_name" value="{{ $transaction->client_name }}" required class="form-control">
            </div>
            <div class="form-group">
                <label for="total_amount">قيمة المعاملة:</label>
                <input type="number" step="0.01" name="total_amount" value="{{ $transaction->total_amount }}" required class="form-control">
            </div>
            <div class="form-group">
                <label for="installment_1">الدفعة 1:</label>
                <input type="number" step="0.01" name="installment_1" value="{{ $transaction->installment_1 }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="installment_2">الدفعة 2:</label>
                <input type="number" step="0.01" name="installment_2" value="{{ $transaction->installment_2 }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="installment_3">الدفعة 3:</label>
                <input type="number" step="0.01" name="installment_3" value="{{ $transaction->installment_3 }}" class="form-control">
            </div>
            <div class="form-group">
                
            </div>
            <button type="submit" class="btn-submit">💾 حفظ التعديلات</button>
        </form>
        <a href="{{ route('accountant') }}" class="btn-back">🔙 العودة إلى لوحة التحكم</a>
    </div>
</body>
</html>