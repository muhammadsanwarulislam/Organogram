<?php

use Illuminate\Support\Facades\Route;
use Sanwarul\Organogram\Http\Controllers\Api\EmployeeController;
use Sanwarul\Organogram\Http\Controllers\Api\PositionController;
use Sanwarul\Organogram\Http\Controllers\Api\DepartmentController;
use Sanwarul\Organogram\Http\Controllers\Api\OrganogramController;
use Sanwarul\Organogram\Http\Controllers\Api\OrganizationController;


Route::middleware(['api'])->prefix('api')->group(function () {
    Route::apiResource('organizations', OrganizationController::class);
    Route::get('organizations/{id}/hierarchy', [OrganizationController::class, 'hierarchy']);
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('positions', PositionController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::get('employees/{id}/attachments', [EmployeeController::class, 'attachments']);
    Route::get('organogram/{organization}', [OrganogramController::class, 'show']);
    Route::get('organogram/{organization}/tree', [OrganogramController::class, 'tree']);
    Route::get('organogram/{organization}/statistics', [OrganogramController::class, 'statistics']);
});
