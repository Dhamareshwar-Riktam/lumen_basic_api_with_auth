<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Closure;

class DishValidation {
    use ApiResponser;

    public function handle($request, Closure $next) {
        if ($request->isMethod('post') || $request->isMethod('put')) {
            $rules = [
                'dish_name' => 'required|max:255',
                'dish_description' => 'required|max:255',
                'dish_price' => 'required|numeric|between:10, 5000',
                'dish_rating' => 'required|numeric|between:0,5',
                'restaurant_id' => 'required|uuid',
            ];

            $validator = Validator::make($request->json()->all(), $rules);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $next($request);
    }
}