<?php


class ItonicsNabinStudentEntity extends Entity
{
    private static array $instances = [];
    /**
     * @throws Exception
     */
    public function __construct($values = [], $entityType = "itonics_nabin_student") {
//        if (empty($values)) {
//            $values = $this->getDefaultData();
//        }
        parent::__construct($values, $entityType);
    }

    /**
     * @return array
     */
    private function getDefaultData(): array
    {
        return [
            "student_id" => 0,
            "first_name" => "",
            "last_name" => "",
            "gender" => "",
            "grade" => "",
            "admission_date" => REQUEST_TIME,
            "profile_picture" => 0,
            "description" => "",
            "created" => REQUEST_TIME,
            "changed" => REQUEST_TIME,
            "faculty_id" => 0,
        ];
    }

    /**
     * @return DrupalEntityControllerInterface|null
     */
    private function getEntityControllerInstance(): ?DrupalEntityControllerInterface
    {
        if (!isset(static::$instances["controller"])) {
            if (isset($this->entityInfo["controller class"])) {
                $controllerClass = new $this->entityInfo["controller class"];
                static::$instances["controller"] = $controllerClass;
            }
        }

        return static::$instances["controller"] ?? null;
    }


    /**
     * @return string
     */
    public function full_name(): string
    {
        return trim($this->first_name . " " . $this->last_name);
    }

    /**
     * @throws Exception
     */
    public function updateOrCreate(): self
    {
        // TRYING OUT STUFF WITH ENTITY CLASS INSTEAD OF USING CONTROLLER CLASS
        $controller = $this->getEntityControllerInstance();

        $transaction  = $transaction ?? db_transaction();
        try {
            if (!empty($this->{$this->idKey}) && !isset($this->original)) {
                $this->original = entity_load_unchanged($this->entityType, $this->{$this->idKey});
            }
            $this->is_new = !empty($this->is_new) || empty($this->{$this->idKey});
            $controller->invoke("presave", $this);

            if ($this->is_new) {

            }
        } catch (Exception $exception) {
            $transaction->rollback();
            watchdog($this->entityType, $exception);
            throw $exception;
        }

        return $this;
    }

}
