<?php
declare(strict_types=1);

namespace Sanwarul\Organogram\Repositories\Position;

use Sanwarul\Organogram\Models\Position;
use Sanwarul\Organogram\Repositories\BaseRepository;

class PositionRepository extends BaseRepository
{
    public function __construct(Position $position)
    {
        parent::__construct($position);
    }

    public function findByCode(string $code)
    {
        return $this->model->where('code', $code)->first();
    }
}