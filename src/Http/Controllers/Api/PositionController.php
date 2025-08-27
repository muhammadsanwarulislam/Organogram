<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sanwarul\Organogram\Traits\JsonResponseTrait;
use Sanwarul\Organogram\Services\Position\PositionService;
use Sanwarul\Organogram\Traits\Translatable;

class PositionController extends Controller
{
    use JsonResponseTrait, Translatable;

    public function __construct(protected PositionService $positionService){}

    public function index()
    {
        try {
            $positions = $this->positionService->getAllPositions();
            return $this->successJsonResponse('Positions retrieved successfully', $positions);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $position = $this->positionService->createPosition($request);
            return $this->successJsonResponse('Position created successfully', $position);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $position = $this->positionService->getPositionById($id);
            return $this->successJsonResponse('Position retrieved successfully', $position);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $position = $this->positionService->updatePosition($request, $id);
            return $this->successJsonResponse('Position updated successfully', $position);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->positionService->deletePosition($id);
            return $this->successJsonResponse('Position deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}