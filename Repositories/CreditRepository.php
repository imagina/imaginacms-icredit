<?php

namespace Modules\Icredit\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CreditRepository extends BaseRepository
{
    public function getItemsBy($params);

    public function getItem($criteria, $params);

    public function updateBy($criteria, $data, $params);

    public function deleteBy($criteria, $params);

    public function amount($params);
}
