<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Данные успешно отправлены</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="alert alert-success">
            <h4 class="alert-heading">Данные успешно отправлены!</h4>
            <p>Спасибо за заполнение формы. Ваши данные были сохранены.</p>
            <hr>
            <p class="mb-0"><a href="{{ route('form') }}" class="alert-link">Вернуться к форме</a></p>
        </div>
    </div>
</body>
</html>