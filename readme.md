# Тестовое задание для кандидата на вакансию backend-разработчика
Небольшой REST API сервис для сбора и редактирования заявок

# Инструкция по развёртыванию

Клонируем репозиторий
```sh
git clone https://github.com/zhenyasayapin/iq-group-test-app.git
```
```sh
cd iq-group-test-app
```
Переименовываем .env.example
```sh
mv src/.env.example src/.env 
```

Указываем APP_SECRET и JWT_PASSPHRASE в .env файле, например, сгенерировав с помощью
```sh
openssl rand -base64 32
```

Запускаем docker compose
```sh
docker compose up 
```
Устанавливаем зависимости composer
```sh
./phpexec.sh composer install
```
Выполняем миграции
```sh
./phpexec.sh bin/console d:m:m
```

Генерируем ключи для JWT
```sh
./phpexec.sh bin/console lexik:jwt:generate-keypair
```

# Postman

Коллекции запросов находятся в папке Postman

1. Запросом Create User или Create Manager создаём пользователя
2. Запросом Get User JWT или Get Manager JWT получаем токен и добавляем его в заголовок Authorization: Bearer
3. Теперь можно использовать запросы чтобы получать/создавать заявки
