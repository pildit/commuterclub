<?php

Class indexController extends baseController {

public function index() {
	/*** set a template variable ***/
        $this->registry->template->welcome = 'This is my welcome page';
	/*** load the index template ***/
        $this->registry->template->show('index');
}

}

?>
