<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Services\Position;

use Sanwarul\Organogram\Repositories\Position\PositionRepository;
use Illuminate\Http\Request;

class PositionService
{
    protected PositionRepository $positionRepository;

    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function getAllPositions()
    {
        return $this->positionRepository->all(['department', 'employee','translations']);
    }

    public function createPosition(Request $request)
    {
        $validated = $this->validatePositionData($request);

        return $this->positionRepository->create($validated);
    }

    public function getPositionById(int $id)
    {
        return $this->positionRepository->find($id, ['department', 'employee']);
    }

    public function updatePosition(Request $request, int $id)
    {
        $validated = $this->validatePositionData($request, $id);
        
        return $this->positionRepository->update($id, $validated);
    }

    public function deletePosition(int $id)
    {
        return $this->positionRepository->delete($id);
    }

    protected function validatePositionData(Request $request, int $id = null): array
    {
        $rules = [
            'department_id' => 'required|exists:departments,id',
            'name'          => 'required|string|max:255',
            'grade'         => 'nullable|integer',
        ];

        if ($id) {
            $rules['code'] = 'sometimes|required|string|unique:positions,code,' . $id;
        } else {
            $rules['code'] = 'required|string|unique:positions,code';
        }
        
        return $request->validate($rules);
    }
}