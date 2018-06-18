<?php 

class apiController extends baseController {

    public function index() {
        echo json_encode(['hello' => 'world']);
    }

    public function calculate() {
        /** retrieve input params (POST) **/
        $loan_amount = $_POST['loanamount'];

        $rate = $_POST['rate'];
        
        $months = $_POST['months']; 

        /** calculate  */

        /** return result */

        try {
            /** save to DB */

        } catch(Exception $e) {


        }

    }
}


?>