<?php

class TeacherView
{
    public function renderList($teachers) {
        $rows = [];

        foreach ($teachers as $teacher) {
            $rows[] = [
                $teacher->id,
                check_plain($teacher->first_name)
            ]
        }

        return theme('table', [
            'header' => [
                'Id',
                'First Name'
            ],
            'rows' => $rows,
        ]);
    }
}