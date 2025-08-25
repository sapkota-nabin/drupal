<?php

class ItonicsNabinStudentController extends EntityAPIController
{
    public function __construct()
    {
        $entityType = "itonics_nabin_student";
        parent::__construct($entityType);
    }

//    public function create() {
//        $entity = new stdClass();
//        $entity->type = $this->entityType;
//        $entity->student_id = 0;
//        $entity->first_name = "";
//        $entity->last_name = "";
//        $entity->profile_picture = 0;
//        $entity->gender = "";
//        $entity->grade = "";
//        $entity->admission_date = REQUEST_TIME;
//        $entity->description = "";
//        $entity->faculty_id = 0;
//        return $entity;
//    }

    /**
     * @throws Exception
     */
    public function getNewEntityObject(): ItonicsNabinStudentEntity
    {
        $entity_default_data = [
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
//            "faculty_id" => 0,
        ];
        drupal_alter("itonics_nabin_student_entity_default_values", $entity_default_data);
        return new ItonicsNabinStudentEntity($entity_default_data);
    }


    /**
     * @throws Exception
     */
    public function save($entity, DatabaseTransaction $transaction = NULL): mixed
    {
        $saved = parent::save($entity, $transaction);
        $message = "";
        drupal_alter('itonics_nabin_faculty_message', $message);
        watchdog('faculty_message', $message);
        drupal_set_message('Student created successfully.');
        return $saved;
    }

    /**
     * @throws Exception
     */
    public function delete($ids, DatabaseTransaction $transaction = NULL): void
    {
        parent::delete($ids, $transaction);
    }


    /**
     * @param array $headers
     * @return mixed
     * @throws Exception
     */
    public function listAll(
        array $headers,
    ): mixed {
        try {
            $results = db_select('itonics_nabin_student_information', 'p')
                ->extend('PagerDefault')
                ->extend('TableSort')
                ->fields('p')
                ->limit(10)
                ->orderByHeader($headers)
                ->execute();
        } catch (Exception $exception) {
            watchdog("{$this->entityType} List all error", $exception->getTraceAsString());
            throw $exception;
        }

        return $results;
    }
}
