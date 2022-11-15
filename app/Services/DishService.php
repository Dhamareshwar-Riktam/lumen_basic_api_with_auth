<?php

namespace App\Services;

use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Http\Response;


class DishService {
    protected $dish;
    protected $restaurant;

    public function __construct(Dish $dish, Restaurant $restaurant) {
        $this->dish = $dish;
        $this->restaurant = $restaurant;
    }

    public function readAllDishes() {
        return $this->dish->readAllDishes();
    }

    public function readDishById($dish_id) {
        return $this->dish->readDishById($dish_id);
    }
    
    public function createDish($data) {
        if ($this->restaurant->readRestaurantById($data['restaurant_id'])) {
            if ($this->dish->readDishByNameAndRestaurantId($data['dish_name'], $data['restaurant_id'])) {
                return [
                    'success' => false,
                    'message' => 'Dish Already Exists',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY
                ];
            } else {
                if ($this->dish->createDish($data)) {
                    return [
                            'success' => true,
                            'message' => 'Dish Addedd Successfully'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Internal Server Error',
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR
                    ];
                }
            }
        } else {
            return [
                'success' => false,
                'message' => 'Restaurant does not exist',
                'code' => Response::HTTP_NOT_FOUND
            ];
        }
    }

    public function updateDish($data, $dish_id) {
        if ($this->dish->readDishById($dish_id)) {
            if ($this->dish->updateDish($data, $dish_id)) {
                return [
                    'success' => true,
                    'message' => 'Dish Updated Successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Internal Server Error',
                    'code' => Response::HTTP_INTERNAL_SERVER_ERROR
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Dish does not exist',
                'code' => Response::HTTP_NOT_FOUND
            ];
        }
    }

    public function deleteDish($dish_id) {
        if ($this->dish->readDishById($dish_id)) {
            if ($this->dish->deleteDish($dish_id)) {
                return [
                    'success' => true,
                    'message' => 'Dish Deleted Successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Internal Server Error',
                    'code' => Response::HTTP_INTERNAL_SERVER_ERROR
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Dish does not exist',
                'code' => Response::HTTP_NOT_FOUND
            ];
        }
    }

    public function readDishesByRestaurantId($restaurant_id) {
        if ($this->restaurant->readRestaurantById($restaurant_id)) {
            $result = $this->dish->readDishesByRestaurantId($restaurant_id);
            return [
                'success' => true,
                'message' => $result
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Restaurant does not exist',
                'code' => Response::HTTP_NOT_FOUND
            ];
        }
    }
}