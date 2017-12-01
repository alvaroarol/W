<?php

namespace Model;

class ExampleModel extends \W\Model\Model{

    public function __construct() {

        parent::__construct();

        $this->setTable('table_name');
        $this->setPrimaryKey('primary_key_column');

    }

}
