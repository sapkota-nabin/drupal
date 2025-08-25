<?php

class ItonicsNabinFacultyController extends EntityAPIController
{
    /**
     * @param string $entityType
     */
    public function __construct(string $entityType = "itonics_nabin_faculty")
    {
        parent::__construct($entityType);
    }

    /**
     * @return ItonicsNabinFacultyEntity
     * @throws Exception
     */
    public function getNewFaculty(): ItonicsNabinFacultyEntity
    {
        $fields = [
            "faculty_id" => 0,
            "name" => "",
            "code" => "",
            "description" => "",
            "created" => REQUEST_TIME,
            "changed" => REQUEST_TIME,
        ];
        drupal_alter("itonics_nabin_faculty_entity_default_values", $fields);
        return new ItonicsNabinFacultyEntity($fields);
    }

    /**
     * @return array
     */
    public function getFormattedListData(): array
    {
        $can_edit   = user_access('edit faculty');
        $can_delete = user_access('delete faculty');
        $can_add    = user_access('add faculty');

        $faculties = db_query('SELECT * FROM {itonics_nabin_faculty}')->fetchAllAssoc('faculty_id');

        $students = db_query('SELECT * FROM {itonics_nabin_student_information} WHERE faculty_id IN (:ids)', [
            ':ids' => array_keys($faculties),
        ])->fetchAll();
        $faculty_students = [];
        foreach ($students as $student) {
            $faculty_students[$student->faculty_id][] = $student;
        }

        $teachers = db_query('SELECT * FROM {itonics_nabin_teacher_information}')->fetchAll();
        $faculty_teachers = [];
        foreach ($teachers as $teacher) {
            if (!empty($teacher->faculties)) {
                $faculty_ids = unserialize($teacher->faculties);
                if (is_array($faculty_ids)) {
                    foreach ($faculty_ids as $fid) {
                        if (isset($faculties[$fid])) {
                            $faculty_teachers[$fid][] = $teacher;
                        }
                    }
                }
            }
        }

        $rows = [];
        foreach ($faculties as $fid => $faculty) {
            $student_names = [];
            if (!empty($faculty_students[$fid])) {
                foreach ($faculty_students[$fid] as $s) {
                    $student_names[] = check_plain($s->first_name . ' ' . $s->last_name);
                }
            }

            $teacher_names = [];
            if (!empty($faculty_teachers[$fid])) {
                foreach ($faculty_teachers[$fid] as $t) {
                    $teacher_names[] = check_plain($t->first_name . ' ' . $t->last_name);
                }
            }

            $actions_markup = [];
            if ($can_edit) {
//                $actions_markup[] = ctools_modal_text_button(
//                    t('Edit'),
//                    "admin/itonics-nabin-faculty/edit/{$fid}",
//                    t('Edit faculty')
//                );
                $actions_markup[] = l(t("Edit"), url("admin/itonics-nabin-faculty/edit/{$fid}"));
            }
            if ($can_delete) {
                $delete_url = url("admin/itonics-nabin-faculty/delete/{$fid}");
                $actions_markup[] = l(t('Delete'), $delete_url);
            }

            $rows[] = [
                'name'     => check_plain($faculty->name),
                'code'     => check_plain($faculty->code),
                'students' => implode(', ', $student_names),
                'teachers' => implode(', ', $teacher_names),
                'actions'  => implode(' | ', $actions_markup),
            ];
        }

        return [
            'rows' => $rows,
            'can_add' => $can_add,
            'add_link' => $can_add
                ? ctools_modal_text_button(t('Add Faculty'), 'admin/itonics-nabin-faculty/add', t('Faculty'))
                : '',
        ];
    }
}
