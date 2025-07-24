<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма заполнения данных</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .representative-card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            position: relative;
        }
        .remove-representative {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Форма заполнения данных</h1>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('form.submit') }}">
            @csrf

            <div class="card mb-4">
                <div class="card-header">
                    <h2>Данные об объекте внедрения</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Полное наименование</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                        <div class="form-text">"Согласно Уставу организации"</div>
                    </div>

                    <div class="mb-3">
                        <label for="short_name" class="form-label">Наименование</label>
                        <input type="text" class="form-control" id="short_name" name="short_name" maxlength="20" required>
                        <div class="form-text">"Без указания на тип организации, только номер или наименование (прилагательное или существительное), не более 20 символов БУДЕТ В ИМЕНИ САЙТА"</div>
                    </div>

                    <div class="mb-3">
                        <label for="locality" class="form-label">Краткое наименование населенного пункта</label>
                        <input type="text" class="form-control" id="locality" name="locality" required>
                        <div class="form-text">"Одно слово, без указания района (например, Ивановское, Троицк), после заполнения требуется обработка и сокращение КУРАТОРАМИ региона БУДЕТ В ИМЕНИ САЙТА, если не совпадает с наименованием"</div>
                    </div>

                    <div class="mb-3">
                        <label for="municipal_district" class="form-label">Наименование муниципального района, муниципального/городского округа</label>
                        <input type="text" class="form-control" id="municipal_district" name="municipal_district">
                        <div class="form-text">Указать наименование муниципального района, муниципального/городского округа (при наличии)</div>
                    </div>

                    <div class="mb-3">
                        <label for="region" class="form-label">Регион</label>
                        <input type="text" class="form-control" id="region" name="region" required>
                        <div class="form-text">"Субъект РФ"</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="inn" class="form-label">ИНН</label>
                            <input type="text" class="form-control" id="inn" name="inn" pattern="\d{10}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ogrn" class="form-label">ОГРН</label>
                            <input type="text" class="form-control" id="ogrn" name="ogrn">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="form-text">Для уведомления о создании сайта</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="text" class="form-control" id="phone" name="phone" pattern="\d{10}" required>
                            <div class="form-text">10 цифр, без знаков, пробелов и без +7/8 в начале. Для городских телефонов – с кодом региона</div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div id="representatives-container">
    <div class="card mb-4 representative-card" id="representative-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Данные уполномоченного представителя #1</h2>
            <button type="button" class="btn btn-danger btn-sm remove-representative" data-id="0" style="display: none;">Удалить</button>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">На обработку моих персональных данных в целях подключения </label>
                <select class="form-control" name="representatives[0][accord]" required>
                    <option value="">Выберите</option>
                    <option value="Согласен">Согласен</option>
                    <option value="Согласна">Согласна</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">ФИО</label>
                <input type="text" class="form-control" name="representatives[0][name]" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Должность</label>
                <input type="text" class="form-control" name="representatives[0][position]" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Мобильный телефон</label>
                <input type="text" class="form-control" name="representatives[0][phone]" pattern="\d{10}" required>
                <div class="form-text">10 цифр, без знаков, пробелов и +7/8 в начале</div>
            </div>

            <div class="mb-3">
                <label class="form-label">СНИЛС</label>
                <input type="text" class="form-control" name="representatives[0][snils]" pattern="\d{11}" required>
                <div class="form-text">11 цифр без пробелов и "-"</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="representatives[0][email]" required>
            </div>
        </div>
    </div>
</div>

        <div class="form-group">
            <label for="captcha">CAPTCHA: {{ $captchaQuestion ?? '' }}</label>
            <input type="text" class="form-control" id="captcha" name="captcha" required>
        </div>

        <br />  
         

<button type="button" id="add-representative" class="btn btn-secondary mb-4">Добавить представителя</button>
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let representativeCount = 1;
    
    document.getElementById('add-representative').addEventListener('click', function() {
        const container = document.getElementById('representatives-container');
        const newCard = document.createElement('div');
        newCard.className = 'card mb-4 representative-card';
        newCard.id = `representative-${representativeCount}`;
        
        newCard.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Данные уполномоченного представителя #${representativeCount + 1}</h2>
                <button type="button" class="btn btn-danger btn-sm remove-representative" data-id="${representativeCount}">Удалить</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Согласие на обработку персональных данных</label>
                    <select class="form-control" name="representatives[${representativeCount}][accord]" required>
                        <option value="">Выберите</option>
                        <option value="Согласен">Согласен</option>
                        <option value="Согласна">Согласна</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">ФИО</label>
                    <input type="text" class="form-control" name="representatives[${representativeCount}][name]" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Должность</label>
                    <input type="text" class="form-control" name="representatives[${representativeCount}][position]" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Мобильный телефон</label>
                    <input type="text" class="form-control" name="representatives[${representativeCount}][phone]" pattern="\\d{10}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">СНИЛС</label>
                    <input type="text" class="form-control" name="representatives[${representativeCount}][snils]" pattern="\\d{11}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="representatives[${representativeCount}][email]" required>
                </div>
            </div>
        `;
        
        container.appendChild(newCard);
        representativeCount++;
        
        
        document.querySelectorAll('.remove-representative').forEach(btn => {
            btn.style.display = 'block';
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-representative')) {
            const id = e.target.getAttribute('data-id');
            const card = document.getElementById(`representative-${id}`);
            card.remove();
            
            
            const cards = document.querySelectorAll('.representative-card');
            cards.forEach((card, index) => {
                card.id = `representative-${index}`;
                card.querySelector('h2').textContent = `Данные уполномоченного представителя #${index + 1}`;
                card.querySelector('.remove-representative').setAttribute('data-id', index);
                
                const inputs = card.querySelectorAll('[name^="representatives["]');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/representatives\[\d+\]/, `representatives[${index}]`);
                    input.setAttribute('name', newName);
                });
            });
            
            representativeCount = cards.length;
            
            if (representativeCount === 1) {
                document.querySelector('.remove-representative').style.display = 'none';
            }
        }
    });
</script>
</body>
</html>