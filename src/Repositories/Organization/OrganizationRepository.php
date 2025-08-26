<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Repositories\Organization;

use Sanwarul\Organogram\Models\Organization;
use Sanwarul\Organogram\Repositories\BaseRepository;

class OrganizationRepository extends BaseRepository
{
    public function __construct(Organization $organization)
    {
        parent::__construct($organization);
    }

    public function findByCode(string $code)
    {
        return $this->model->where('code', $code)->first();
    }
}