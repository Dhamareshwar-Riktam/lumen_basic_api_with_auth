<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Services\DishService;


class DishController extends Controller {
    use ApiResponser;

    protected $dishService;

    public function __construct(DishService $dishService) {
        $this->dishService = $dishService;
    }

    public function index() {
        return $this->successResponse($this->dishService->readAllDishes());
    }

    public function show($dish_id) {
        $result = $this->dishService->readDishById($dish_id);

        if ($result) {
            return $this->successResponse($result);
        } else {
            return $this->errorResponse('Dish Not Found', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request) {
        $result = $this->dishService->createDish($request->json()->all());

        if ($result['success']) {
            return $this->successResponse($result['message'], Response::HTTP_CREATED);
        } else {
            return $this->errorResponse($result['message'], $result['code']);
        }
    }

    public function update(Request $request, $dish_id) {
        $result = $this->dishService->updateDish($request->json()->all(), $dish_id);

        if ($result['success']) {
            return $this->successResponse($result['message']);
        } else {
            return $this->errorResponse($result['message'], $result['code']);
        }
    }

    public function destroy($dish_id) {
        $result = $this->dishService->deleteDish($dish_id);

        if ($result['success']) {
            return $this->successResponse($result['message']);
        } else {
            return $this->errorResponse($result['message'], $result['code']);
        }
    }

    public function getDishesByRestaurantId($restaurant_id) {
        $result = $this->dishService->readDishesByRestaurantId($restaurant_id);

        if ($result['success']) {
            return $this->successResponse($result['message']);
        } else {
            return $this->errorResponse($result['message'], $result['code']);
        }
    }
}