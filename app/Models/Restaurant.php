<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class Restaurant extends Model {
    use HasFactory;

    protected $table = 'restaurants';

    protected $primaryKey = 'restaurant_name';

    public $timestamps = true;
    
    protected $fillable = [
        'restaurant_name',
        'restaurant_address',
        'restaurant_rating',
    ];

    public function readAllRestaurants() {
        return DB::table('restaurants')->get();
    }

    public function readRestaurantById($restaurant_id) {
        return DB::table('restaurants')->where('restaurant_id', $restaurant_id)->first();
    }

    public function readRestaurantByName($restaurant_name) {
        return DB::table('restaurants')->where('restaurant_name', $restaurant_name)->first();
    }

    public function createRestaurant($data) {
        $restaurant_id = Str::uuid();

        try {
            DB::transaction(function () use ($data, $restaurant_id) {
                DB::table('restaurants')->insert([
                    'restaurant_id' => $restaurant_id,
                    'restaurant_name' => $data['restaurant_name'],
                    'restaurant_address' => $data['restaurant_address'],
                    'restaurant_rating' => $data['restaurant_rating'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

                DB::table('history')->insert([
                    'restaurant_id' => $restaurant_id,
                    'message' => 'Restaurant created',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            });
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function updateRestaurant($data, $restaurant_id) {
        return DB::table('restaurants')->where('restaurant_id', $restaurant_id)->update([
            'restaurant_name' => $data['restaurant_name'],
            'restaurant_address' => $data['restaurant_address'],
            'restaurant_rating' => $data['restaurant_rating'],
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function deleteRestaurant($restaurant_id) {
        return DB::table('restaurants')->where('restaurant_id', $restaurant_id)->delete();
    }
}