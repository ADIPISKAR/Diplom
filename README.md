# Система аренды повербанков

Laravel-приложение для управления арендой устройств: станции, повербанки, тарифы, пользователи, аренды, платежи и журнал ошибок.

## Реализовано

- База данных через Laravel migrations: `users`, `stations`, `powerbanks`, `rentals`, `payments`, `tariffs`, `error_logs`.
- Eloquent-модели и связи между сущностями.
- CRUD для станций, повербанков, тарифов, платежей и журнала ошибок.
- Создание и завершение аренды с автоматическим изменением статуса повербанка.
- Единый веб-интерфейс администратора на главной странице.
- Seeder с демонстрационными пользователями и данными.

## Запуск

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Для локальной демонстрации можно использовать SQLite, указав в `.env`:

```env
DB_CONNECTION=sqlite
```

Для MySQL создайте базу `device_rental`, проверьте доступы в `.env`, затем выполните:

```bash
php artisan migrate:fresh --seed
```
