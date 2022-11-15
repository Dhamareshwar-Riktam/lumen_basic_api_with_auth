<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Dish extends Model {

    use HasFactory;
    
    protected $table = 'dishes';

    protected $primaryKey = 'dish_id';

    public $timestamps = true;
    
    protected $fillable = [
        'dish_name',
        'dish_description',
        'dish_price',
        'dish_rating',
        'restaurant_id',
    ];

    public function readAllDishes() {
        return DB::table('dishes')->get();
    }

    public function readDishById($dish_id) {
        return DB::table('dishes')->where('dish_id', $dish_id)->first();
    }

    public function readDishByNameAndRestaurantId($dish_name, $restaurant_id) {
        return DB::table('dishes')
            ->where('dish_name', $dish_name)
            ->where('restaurant_id', $restaurant_id)
            ->first();
    }

    public function createDish($data) {
        $dish_id = Str::uuid();

        try {
            DB::transaction(function () use ($data, $dish_id) {
                DB::table('dishes')->insert([
                    'dish_id' => Str::uuid(),
                    'dish_name' => $data['dish_name'],
                    'dish_description' => $data['dish_description'],
                    'dish_price' => $data['dish_price'],
                    'dish_rating' => $data['dish_rating'],
                    'restaurant_id' => $data['restaurant_id'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

                DB::table('history')->insert([
                    'dish_id' => $dish_id,
                    'message' => 'Dish created',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            });
        } catch(Exception $e) {
            return false;
        }
        return true;
    }

    public function updateDish($data, $dish_id) {
        return DB::table('dishes')
            ->where('dish_id', $dish_id)
            ->update([
                'dish_name' => $data['dish_name'],
                'dish_description' => $data['dish_description'],
                'dish_price' => $data['dish_price'],
                'dish_rating' => $data['dish_rating'],
                'restaurant_id' => $data['restaurant_id'],
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
    }

    public function deleteDish($dish_id) {
        return DB::table('dishes')->where('dish_id', $dish_id)->delete();
    }

    public function readDishesByRestaurantId($restaurant_id) {
        return DB::table('dishes')
            -> where('restaurant_id', $restaurant_id)
            -> get();
    }
}