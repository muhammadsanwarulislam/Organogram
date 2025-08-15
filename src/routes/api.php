<?php

use Illuminate\Support\Facades\Route;
use Sanwarul\Organogram\Controllers\Http\Api\OrganizationController;
use Sanwarul\Organogram\Controllers\Http\Api\DepartmentController;
use Sanwarul\Organogram\Controllers\Http\Api\PositionController;
use Sanwarul\Organogram\Controllers\Http\Api\EmployeeController;
use Sanwarul\Organogram\Controllers\Http\Api\OrganogramController;


Route::middleware(['api'])->prefix('api')->group(function () {
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('positions', PositionController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::get('organogram/{organization}', [OrganogramController::class, 'show']);
    Route::get('organogram/{organization}/tree', [OrganogramController::class, 'tree']);
});
