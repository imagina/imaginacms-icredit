<?php

namespace Modules\Icredit\Entities;

/**
 * Class Status
 * @package Modules\icommerce\Entities
 */
class Status
{
    const PENDING = 1;
    const AVAILABLE = 1;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::PENDING => trans('icredit::status.disabled'),
            self::AVAILABLE => trans('icredit::status.enabled'),
        ];
    }

    /**
     * Get the available statuses
     * @return array
     */
    public function lists()
    {
        return $this->statuses;
    }

    /**
     * Get the post status
     * @param int $statusId
     * @return string
     */
    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::AVAILABLE];
    }
}
