<?php


class ItonicsNabinTeacherEntityBaseController extends EntityAPIController
{
    public ?string $baseEntityType = "";
    public function __construct() {
        $entityType = $this->baseEntityType;
        parent::__construct($entityType);
    }

    /**
     * @throws Exception
     */
    public function save($entity, DatabaseTransaction $transaction = NULL): bool|int|null
    {
        return parent::save($entity, $transaction);
    }

    /**
     * @throws Exception
     */
    public function delete($entity, DatabaseTransaction $transaction = NULL): void
    {
        parent::delete($entity, $transaction);
    }
}
