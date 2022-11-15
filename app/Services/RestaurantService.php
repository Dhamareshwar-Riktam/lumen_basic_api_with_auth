<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Http\Response;


class RestaurantService {
    protected $restaurant;

    public function __construct(Restaurant $restaurant) {
        $this->restaurant = $restaurant;
    }

    public function readAllRestaurants() {
        return $this->restaurant->readAllRestaurants();
    }

    public function readRestaurantById($restaurant_id) {
        return $this->restaurant->readRestaurantById($restaurant_id);
    }

    public function readRestaurantByName($restaurant_name) {
        return $this->restaurant->readRestaurantByName($restaurant_name);
    }

    public function createRestaurant($data) {
        if ($this->readRestaurantByName($data['restaurant_name'])) {
            return [
                'success' => false,
                'message' => 'Restaurant already exists',
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY
            ];
        } else if ($this->restaurant->createRestaurant($data)) {
            return [
                'success' => true,
                'message' => 'Restaurant Added Successfully',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Internal Server Error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function updateRestaurant($data, $restaurant_id) {
        if ($this->readRestaurantById($restaurant_id)) {
            if ($this->restaurant->updateRestaurant($data, $restaurant_id)) {
                return [
                    'success' => true,
                    'message' => 'Restaurant Updated Successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Internal Server Error',
                    'code' => Response::HTTP_INTERNAL_SERVER_ERROR
                ];
            }
        } else {
            return ['success' => false, 'message' => 'Restaurant not found', 'code' => Response::HTTP_NOT_FOUND];
        }
    }

    public function deleteRestaurant($restaurant_id) {
        if ($this->readRestaurantById($restaurant_id)) {
            if ($this->restaurant->deleteRestaurant($restaurant_id)) {
                return [
                    'success' => true,
                    'message' => 'Restaurant Deleted Successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Internal Server Error',
                    'code' => Response::HTTP_INTERNAL_SERVER_ERROR
                ];
            }
        } else {
            return ['success' => false, 'message' => 'Restaurant not found', 'code' => Response::HTTP_NOT_FOUND];
        }
    }
}