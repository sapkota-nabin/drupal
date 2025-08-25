<?php

/**
 *
 */
class ItonicsNabinStateController extends ItonicsNabinTeacherEntityBaseController
{
    public function __construct() {
        $this->baseEntityType = "itonics_nabin_state";
        parent::__construct();
    }

    /**
     * @return array[]
     */
    private function getSampleData(): array
    {
        return [
            'Koshi' => [
                'Morang',
                'Sunsari',
                'Jhapa',
            ],
            'Madhesh' => [
                'Dhanusha',
                'Sarlahi',
                'Bara',
            ],
            'Bagmati' => [
                'Kathmandu',
                'Chitwan',
                'Makwanpur',
            ],
            'Gandaki' => [
                'Baglung',
                'Gorkha',
                'Kaski',
            ],
            'Lumbini' => [
                'Kapilvastu',
                'Parasi',
                'Rupandehi',
            ],
            'Karnali' => [
                'Humla',
                'Jumla',
                'Kalikot',
            ],
            'Sudurpashchim' => [
                'Achham',
                'Darchula',
                'Bajhang',
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function populateState(): void
    {
        $sample_data = $this->getSampleData();
        $states_query = db_select('itonics_nabin_states', 's');
        $states_query->addExpression('COUNT(state_id)', 'total_states');
        $states = $states_query->execute()->fetchField();

        if ($states == 0) {
            $query =  db_insert('itonics_nabin_states')
                ->fields(['state_name']);
            foreach (array_keys($sample_data) as $state) {
                $query->values(['state_name' => $state]);
            }

            $query->execute();
        }

        $states = db_select('itonics_nabin_states', 's')
            ->fields('s')
            ->execute()
            ->fetchAllAssoc('state_id');

        $district_controller = entity_get_controller("itonics_nabin_district");

        $regions_count = $district_controller->getCount();

        if ($regions_count == 0) {
            $districts_insert_data = [];
            foreach ($states as $state) {
                $state_wise_districts = $sample_data[$state->state_name] ?? [];
                if (count($state_wise_districts)) {
                    foreach ($state_wise_districts as $district) {
                        $districts_insert_data[] = [
                            'state_id' => $state->state_id,
                            'district_name' => $district,
                        ];
                    }
                }
            }
            if (count($districts_insert_data)) {
                $district_controller->populateDistricts($districts_insert_data);
            }
        }

    }

    /**
     * @param array $fields
     * @return mixed
     */
    public function getAllWithoutPagination(array $fields = []): mixed
    {
        return db_select('itonics_nabin_states', 't')
            ->fields('t', $fields)
            ->execute()
            ->fetchAll();
    }

}
