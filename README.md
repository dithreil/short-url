## Генератор укороченных ссылок
Тестовый проект:
* Symfony backend

## Как развернуть проект
### Скачивание необходимых файлов:
```shell script
git clone https://github.com/dithreil/short-url.git
cd short-url
composer install
```

### Прописать необходимые переменные в env.local:
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7" `соединение MySQL c базой данных`

### Создание базы данных
> создание БД
```shell script
php bin/console doctrine:database:create
```
> создание таблиц
```shell script
php bin/console doctrine:migrations:migrate
```

> запуск встроенного веб-сервера
```shell script
symfony serve
