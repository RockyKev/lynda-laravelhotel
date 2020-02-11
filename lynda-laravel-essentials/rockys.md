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

3. Create a CONTROLLER

-> Create a single action controller that's 'invokable'
-> Or create one with all the default resources

```
php artisan make:controller ShowRoomsController --invokable
php artisan make:controller BookingController --resource --model=Booking
```

4. Create the VIEW
   After creating the controllers, you can then create the blades manually, or via a folder.

```
bookings/
    index.blade.php
    show.blade.php

```

## Random things to know

Laravel has a thing called Facades which displays data from the database.

It's a set of tools
Designs to be classes with functions on them, to talk to the wide variety of the laravel ecosystems.
Makes the services to access various laravel tools effortless.
For example:

DB::table(xx):

Options can be called
CRUD or BREAD
Create, Read, Update, Delete.

### Null Start operator

```
($booking->start ?? '')
```

This is saying.... if the first value exists, show that. Otherwise, show the second value.

### pluck

Laravel has a method for collections called pluck, which plucks a value key pair from the collection.
it returns an array with the first param as value; second param as the key for the arrya.

## Eloquent

Laravel's object/relationship mapper.

### Recipe for quickly dumping your data to see if it works

This is in the BookingController

```
    public function index()
    {
        \DB::table('bookings')->get()->dd();

    }
```

dd() = laravel's var_dump and die.

### Routing simplify

THIS

```
Route::get('/bookings', 'BookingController@index');
Route::get('/bookings/create', 'BookingController@create');
Route::post('/bookings', 'BookingController@store');
Route::get('/bookings/{booking}', 'BookingController@show');
Route::get('/bookings/{booking}/edit', 'BookingController@edit');
Route::put('/bookings/{booking}', 'BookingController@update');
Route::delete('/bookings/{booking}', 'BookingController@destroy');
```

Is the same as

```
Route::resource('bookings', 'BookingController');

```

### Passing data from the Controller to the View

Both are the same.

```
    //option 1
    return view('rooms.index', ['rooms' => $rooms]);

    //option 2
    return view('bookings.index')->with('bookings', $bookings);
```
