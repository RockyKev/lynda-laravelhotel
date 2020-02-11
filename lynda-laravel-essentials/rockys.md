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

### Eloquent Types

One-to-one relationships

One-to-many relationships

Many-to-Many relationships

Lazy-loading relationships

Eager Loading

Saving relationships

### Facades

Laravel has a thing called Facades which displays data from the database.

It's a set of tools
Designs to be classes with functions on them, to talk to the wide variety of the laravel ecosystems.
Makes the services to access various laravel tools effortless.
For example:

DB::table(xx):

Options can be called
CRUD or BREAD
Create, Read, Update, Delete.

### To quickly generate something from the DB

```
        // $rooms = DB::table('rooms')->get();

```

### Inserting into the database

```
    $id = DB::table('bookings')->insertGetId([
        'room_id' => $request->input('room_id'),
        'start' => $request->input('start'),
        'end' => $request->input('end'),
        'is_reservation' => $request->input('is_reservation', false),
        'is_paid' => $request->input('is_paid', false),
        'notes' => $request->input('notes')
    ]);

    DB::table('bookings_users')->insert([
        'booking_id' => $id,
        'user_id' => $request->input('user_id'),
    ]);
```

Is akin to:

```
    $booking = Booking::create($request->input());

    DB::table('bookings_users')->insert([
        'booking_id' => $booking->id,    //CHANGE THIS TOO
        'user_id' => $request->input('user_id'),
    ]);
```

This is called a MASS ASSIGNMENT.
This method permits anyone to blindly send anything to the database. So you'll have to modify the Booking Model as well.

In Booking.php:

```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id', 'start', 'end', 'is_reservation', 'is_paid', 'notes'
    ];
}
```

### Soft Deletes

SoftDeletes allow you to 'remove' the object but not from the databse.

```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //THIS

class Booking extends Model
{
    use SoftDeletes;  //THIS
    protected $fillable = [
        'room_id', 'start', 'end', 'is_reservation', 'is_paid', 'notes'
    ];
}

```

Then update a page to show the content.

```
class BookingController extends Controller
{
    public function index()
    {

        Booking::withTrashed()->get()->dd(); //this says get the trashed, and data dump it.

        $bookings = Booking::paginate(20);
        return view('bookings.index')->with('bookings', $bookings);
    }

```

### Doing SQL clauses

```
    $rooms = Room::where('room_type_id', '!=', $roomType)->get();
```

It's akin to

```
SELECT * FROM 'Room' WHERE 'room_type_id' NOT EQUAL '$roomType';
```

### To get the params

```
    //this is to take params in the url .com/rooms?id=2
    if ($request->query('id') !== null) {
        $rooms = $rooms->where('room_type_id', $request->query('id'));
    }

```

### Want to get the database for cleaner code?

```

    use App\Room;

    function name() {

        <!-- $rooms = DB::table('rooms')->get(); -->
        $rooms = Room::get();

    }

```

### To quickly test if a page returns something

```

// To return test data -- return response('A listing of rooms', 200);

```

### building factories

```

php artisan make:model --factory Room

```

### Null Start operator

```

(\$booking->start ?? '')

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

```

```
