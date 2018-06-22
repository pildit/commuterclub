<?php 

class math {
 

public static function calc_payment($pv, $payno, $int, $accuracy = 2    )
{

    $int    = $int / 1200 ;    // convert to a percentage
    $value1 = $int * pow((1 + $int), $payno);
    $value2 = pow((1 + $int), $payno) - 1;
    $pmt    = $pv * ($value1 / $value2);
    // $accuracy specifies the number of decimal places required in the result
    $pmt    = number_format($pmt, $accuracy, ".", "");

    return $pmt;

}

public static function get_schedule($balance, $rate, $payment, $user_id)
{
    $count = 0;
    $results = array();
    $start_date = date('d/M/Y');
    $cumulative_principal = $cumulative_interest = 0;

    do {
        $count++;
        $curr_date = (isset($curr_date) ?  strtotime("+7 day", $curr_date) : strtotime("+7 day") ) ;
        $beginning_balance = $balance;
        
        // calculate interest on outstanding balance
        $interest = $balance * $rate/1200;

        // what portion of payment applies to principal?
        $principal = $payment - $interest;

        // watch out for balance < payment
        if ($balance < $payment) {
            $principal = $balance;
            $payment   = $interest + $principal;
        } // if

        // reduce balance by principal paid
        $balance = $balance - $principal;

        // watch for rounding error that leaves a tiny balance
        if ($balance < 0) {
            $principal = $principal + $balance;
            $interest  = $interest - $balance;
            $balance   = 0;
        } // if

        if ($count > 1) {
            $cumulative_principal += $principal;
            $cumulative_interest  += $interest;
        }

        // Columns : Period, Beginning Balance, Payment, Principal, Interest, Cumulative Principal, Cumulative Interest and Ending Balance.

        $results[] = [$user_id, 
                    date('Y-m-d', $curr_date), 
                    $beginning_balance, 
                    $payment,  
                    $principal, 
                    $interest,  
                    ($count > 1 ?  $cumulative_principal : ""),
                    ($count > 1 ?  $cumulative_interest : ""),                    
                    $balance,                                           
        ];
        

        @$totPayment   = $totPayment + $payment;
        @$totInterest  = $totInterest + $interest;
        @$totPrincipal = $totPrincipal + $principal;

        if ($payment < $interest) {
            echo "<p>Payment < Interest amount - rate is too high, or payment is too low</p>";
            exit;
        } // if

    } while ($balance > 0);

    return $results;
    }

}