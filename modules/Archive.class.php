<?php

class Archive {

    static function setMonths($array) {
        global $smarty;

        $years = array();
        foreach ($array as $post) {
            $month = (new DateTime($post["postdate"]))->format('m');
            $year = (new DateTime($post["postdate"]))->format('y');

            if(!isset($years[$year])){
                $years[$year] = array();
            }

            if (!in_array($month, $years[$year])) {
                $years[$year][] = $month;
            }
        }
        asort($years);

        foreach($years as $year){
            asort($year);
        }

        $smarty->assign("years", $years);
    }

    /*static function setMonths($array) {
        global $smarty;

        $months = array();
        foreach ($array as $post) {
            $month = (new DateTime($post["postdate"]))->format('m');
            if (!in_array($month , $months)) {
                $months[] = $month;
            }
        }
        asort($months);

        $smarty->assign("months", $months);
    }*/

    static function getMonthArray($array, $month) {
        $monthArray = array();

        foreach ($array as $post) {
            if ((new DateTime($post["postdate"]))->format('m') == $month) {
                $monthArray[] = $post;
            }
        }

        return $monthArray;
    }

    static function generateArchive($array, $datetime) {
        $month = (new DateTime($datetime))->format('m');
        foreach ($array as $post) {
            if ((new DateTime($post["postdate"]))->format('m') == $month) {
                return $month;
            }
        }
    }

    static function monthNumberToString($numMonth) {

        switch ($numMonth) {
            case 01 : return "Januar";
            case 02 : return "Februar";
            case 03 : return "Mars";
            case 04 : return "April";
            case 05 : return "Mai";
            case 06 : return "Juni";
            case 07 : return "Juli";
            case '08' : return "August";
            case '09' : return "September";
            case 10 : return "Oktober";
            case 11 : return "November";
            case 12 : return "Desember";
        }
    }

}
