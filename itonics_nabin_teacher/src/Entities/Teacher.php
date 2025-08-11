<?php

class Teacher
{
    protected $table = 'itonics_nabin_teacher';

    public function all() {
        return db_select($this->table, 't')
            ->fields('t')
            ->execute()
            ->fetchAll();
    }
}