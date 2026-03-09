<head>
    <title>اضافة معاملة جديدة </title>
</head>
<style>
    form {
    max-width: 450px;
    margin: 20px auto;
    padding: 20px;
    background: linear-gradient(135deg, #f9f9f9, #ffffff);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

label {
    display: block;
    font-weight: bold;
    margin-top: 10px;
    color: #555;
}

input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: border 0.3s ease-in-out;
}

input:focus {
    border-color: #007bff;
    outline: none;
}

button {
    width: 100%;
    background: #007bff;
    color: white;
    padding: 10px;
    margin-top: 15px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #0056b3;
}

</style>
<h2>إضافة معاملة جديدة</h2>

<form action="{{ route('transactions.store') }}" method="POST">
    @csrf

    <label>اسم المعاملة:</label>
    <input type="text" name="transaction_name" required>

    <label>كود المعاملة:</label>
    <input type="text" name="transaction_code" required>

    <label>اسم العميل:</label>
    <input type="text" name="client_name" required>

    <label>قيمة المعاملة:</label>
    <input type="number" name="total_amount"  required>

    <label>الدفعة الأولى:</label>
    <input type="number" name="installment_1" step="0.01">

    <label>الدفعة الثانية:</label>
    <input type="number" name="installment_2" step="0.01">

    <label>الدفعة الثالثة:</label>
    <input type="number" name="installment_3" step="0.01">

    <button type="submit">حفظ</button>
</form>

