<?php

/**
 * Class progressbar
 *
 * This class is provided "as-is"
 *
 * It only gives you general ideas how to use this progress bar. You will have to incorporate it with whatever
 * you want it to be incorporated into.
 *
 */
class  progressbar {


    /**
     * Including this nice little function that can tell you the percentage of any number.
     * Basically all your need.
     * Eg.   10  of 40   calc(10,40);
     *       30  of 88
     *
     * usage:
     * $ajax->progressbar($this->calc(20, 200));
     *
     * for example, you have a process that takes 15 steps to complete
     * just pass the increment and the total.
     *
     *
     * @param $total
     * @param $number
     * @return float|int
     */
    function calc($total, $number)
    {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }


    function start($progressbar_num, $percentage)
    {
        $ajax = ajax();

        if($percentage >= 100) {

            $ajax->progressbar('#progressbar' . $progressbar_num, 100);

            return false;
        }

        $steps = 10;

        switch ($progressbar_num) {
            case 2:

                $steps = 15;
                sleep(2);
                break;
            case 3:

                $steps = 25;

                sleep(1);

                break;
            case 4:

                $steps = 5;

                sleep(1);
        }

        $percentage += $steps;


        $ajax->progressbar('#progressbar' . $progressbar_num, $percentage);

        $ajax->call(array('progressbar','start', array($progressbar_num,$percentage)));

    }
}