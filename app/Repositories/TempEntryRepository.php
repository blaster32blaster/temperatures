<?php

namespace App\Repositories;

use App\Models\TempEntry;

/**
 * hanlde temp entry model business logic
 */
class TempEntryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(resolve(TempEntry::class));
    }
}
