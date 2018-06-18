<?php 

class math {

public static function calc_principal($payno, $int, $pmt)
{

$int    = $int / 100;        //convert to percentage
$value1 = (pow((1 + $int), $payno)) - 1;
$value2 = $int * pow((1 + $int), $payno);
$pv     = $pmt * ($value1 / $value2);
$pv     = number_format($pv, 2, ".", "");

return $pv;

} 

public static function calc_number($pv, $int, $pmt)
{

$int    = $int / 100;
$value1 = log(1 - $int * ($pv / $pmt));
$value2 = log(1 + $int);
$payno  = $value1 / $value2;
$payno  = abs($payno);
$payno  = number_format($payno, 0, ".", "");

return $payno;

} 

public static function calc_rate($pv, $payno, $pmt)
{

// now try and guess the value using the binary chop technique
$GuessHigh   = (float)100;    // maximum value
$GuessMiddle = (float)2.5;    // first guess
$GuessLow    = (float)0;      // minimum value
$GuessPMT    = (float)0;      // result of test calculation

do {
   // use current value for GuessMiddle as the interest rate,
   // and set level of accurracy to 6 decimal places
   $GuessPMT = (float)calc_payment($pv, $payno, $GuessMiddle, 6);

   if ($GuessPMT > $pmt) {    // guess is too high
      $GuessHigh   = $GuessMiddle;
      $GuessMiddle = $GuessMiddle + $GuessLow;
      $GuessMiddle = $GuessMiddle / 2;
   } // if

   if ($GuessPMT < $pmt) {    // guess is too low
      $GuessLow    = $GuessMiddle;
      $GuessMiddle = $GuessMiddle + $GuessHigh;
      $GuessMiddle = $GuessMiddle / 2;
   } // if

   if ($GuessMiddle == $GuessHigh) break;
   if ($GuessMiddle == $GuessLow) break;

   $int = number_format($GuessMiddle, 9, ".", "");    // round it to 9 decimal places
   if ($int == 0) {
      echo "<p class='error'>Interest rate has reached zero - calculation error</p>";
      exit;
   } // if

} while ($GuessPMT !== $pmt);

return $int;

} 

public static function calc_payment($pv, $payno, $int, $accuracy = 2    )
{

$int    = $int / 100;    // convert to a percentage
$value1 = $int * pow((1 + $int), $payno);
$value2 = pow((1 + $int), $payno) - 1;
$pmt    = $pv * ($value1 / $value2);
// $accuracy specifies the number of decimal places required in the result
$pmt    = number_format($pmt, $accuracy, ".", "");

return $pmt;

}

public static function get_schedule($balance, $rate, $payment)
{
    $count = 0;
    $results = array();

    do {
    $count++;

    // calculate interest on outstanding balance
    $interest = $balance * $rate/100;

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

    $results[] = [$count, 
                number_format($payment,   2, ".", ","), 
                number_format($interest,  2, ".", ","), 
                number_format($principal, 2, ".", ","), 
                number_format($balance,   2, ".", ",") ];
    

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