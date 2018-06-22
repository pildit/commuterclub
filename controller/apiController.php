<?php 

class apiController extends baseController {

    public function index() {
        echo json_encode(['hello' => 'world']);
    }

    public function calculate() {
        $db = $this->registry->db;

        /** retrieve input params (POST) and check them **/
        $loan_amount = $_POST['loanamount'];
        $rate = $_POST['rate'];
        $months = $_POST['months'];
        // hard-coded $user_id
        $user_id = 7;

        /** return status */
        $status = 200;

        try {
            /** calculate the schedule  */
            $payment = math::calc_payment($loan_amount, $months, $rate);
            
            $results = math::get_schedule($loan_amount, $rate, $payment, $user_id);
            // print_r($results);die();
            /** save to DB */
            $cols = ['user_id',
            'period',
            'beginning_balance' ,
            'payment',
            'principal',
            'interest',
            'cumulative_principal',
            'cumulative_interest',
            'ending_balance'];

            // db::save_rows_to_table("amortization_schedule", $cols, $results);

            // retrieve results from DB 
            $response = db::select_from_table("amortization_schedule", " user_id  =  $user_id ");
            // return result
            echo $this->json_response($response, $status);
        } catch(Exception $e) {
            /* return error */ 
            $message = $e->getMessage();
            $status = 500;

            echo $this->json_response($message, $status);

        }

    }
    
    /* @param float $apr   Interest rate. */
    /* @param integer $term  Loan length in years. */ 
    /* @param float $loan   The loan amount. */

    private function calPMT($apr, $term, $loan)
    {
        $term = $term * 12;
        $apr = $apr / 1200;
        $amount = $apr * -$loan * pow((1 + $apr), $term) / (1 - pow((1 + $apr), $term));
        return round($amount);
    }
}


?>