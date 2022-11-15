<?php

namespace App\Http\Controllers;

use App\Services\RestaurantService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;


class RestaurantController extends Controller {
    use ApiResponser;

    protected $restaurantService;

    public function __construct(RestaurantService $restaurantService) {
        $this->restaurantService = $restaurantService;
    }

    public function index() {
        return $this->successResponse($this->restaurantService->readAllRestaurants());
    }

    public function show($restaurant_id) {
        $restaurant = $this->restaurantService->readRestaurantById($restaurant_id);

        if ($restaurant) {
            return $this->successResponse($restaurant);
        } else {
            return $this->errorResponse('Restaurant not found', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request) {
        $result = $this->restaurantService->createRestaurant($request->json()->all());

        if ($result['success']) {
            return $this->successResponse($result['message'], Response::HTTP_CREATED);
        } else {
            return $this->errorResponse($result['message'], $result['code']);
        }
    }

    public function update(Request $request, $restaurant_id) {
        $result = $this->restaurantService->updateRestaurant($request->json()->all(), $restaurant_id);

        if ($result['success']) {
            return $this->successResponse($result['message']);
        } else {
            return $this->errorResponse($result['message'], $result['code']);
        }
    }

    public function destroy($restaurant_id) {
        $result = $this->restaurantService->deleteRestaurant($restaurant_id);

        if ($result['success']) {
            return $this->successResponse($result['message']);
        } else {
            return $this->errorResponse($result['message'], $result['code']);
        }
    }
}