<?php

class TeacherController
{
    public function listTeachers() {
        $model = TeacherServiceContainer::get('model');
        $view = TeacherServiceContainer::get('view');

        $teachers = $model->all();
        return $view->renderList($teachers);
    }
}
