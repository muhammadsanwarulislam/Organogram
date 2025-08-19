<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sanwarul\Organogram\Models\Position;
use Sanwarul\Organogram\Traits\JsonResponseTrait;

class PositionController extends Controller
{
    use JsonResponseTrait;
    public function index()
    {
        try {
            $positions = Position::with(['department', 'employee'])->get();
            return $this->successJsonResponse('Positions retrieved successfully', $positions);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'department_id' => 'required|exists:departments,id',
                'name'          => 'required|string|max:255',
                'code'          => 'required|string|unique:positions,code',
                'grade'         => 'required|nullable|integer',
            ]);

            $position = Position::create($request->all());
            return $this->successJsonResponse('Position created successfully', $position);
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $position = Position::findOrFail($id);
            return $this->successJsonResponse('Position retrieved successfully', $position->load(['department', 'employee']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $position = Position::findOrFail($id);
            $request->validate([
                'department_id' => 'sometimes|required|exists:departments,id',
                'name' => 'sometimes|required|string|max:255',
                'code' => 'sometimes|required|string|unique:positions,code,'.$position->id,
                'grade' => 'nullable|integer',
            ]);
            $position->update($request->all());
            return $this->successJsonResponse('Position updated successfully', $position->load(['department', 'employee']));
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $position = Position::findOrFail($id);
            $position->delete();
            return $this->successJsonResponse('Position deleted successfully');
        } catch (\Exception $e) {
            return $this->errorJsonResponse($e->getMessage());
        }
    }
}