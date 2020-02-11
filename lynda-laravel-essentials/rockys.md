## Setup

Sequence of events

1. set up a migration table --

```
php artisan make:migration create_hotel_tables --create=rooms
```

2. Optional - SEED it
   You can use Factories if you have models.

```
php artisan make:seeder HotelSeeder

/* modify the seed file */

php artisan db:seed

```
