<?php

class ItonicsNabinDistrictController extends ItonicsNabinTeacherEntityBaseController
{
    public function __construct() {
        $this->baseEntityType = "itonics_nabin_district";
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        $regions_count_query = db_select('itonics_nabin_district', 'r');
        $regions_count_query->addExpression('COUNT(district_id)', 'total_regions');
        return $regions_count_query->execute()->fetchField() ?? 0;
    }


    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function populateDistricts(array $data = []): void
    {
        if (count($data)) {
            $district_insert_query = db_insert('itonics_nabin_district')
                ->fields(['district_name', 'state_id']);
            foreach ($data as $district_data) {
                $district_insert_query->values($district_data);
            }

            $district_insert_query->execute();

        }
    }

    /**
     * @param int $stateId
     * @return mixed
     */
    public function getByStateId(int $stateId): mixed
    {
        return db_select('itonics_nabin_district', 'r')
            ->fields('r', ['district_id', 'district_name'])
            ->condition('state_id', $stateId)
            ->execute()
            ->fetchAll();
    }
}
