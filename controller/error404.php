<?php

Class error404Controller Extends baseController {

public function index() 
{
        $this->registry->template->error_heading = 'This is the 404';
        $this->registry->template->show('error404');
}


}
?>
