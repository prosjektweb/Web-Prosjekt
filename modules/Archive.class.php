<?php

class Archive {

    /**
     * @param $array
     *
     * Lager et array som inndeholder ett array for vert år som det er lagret post i basen, hvert av underarayene ingdeholder et felt per måned med poster.
     * Avslutter med å assigne arrayet til smarty
     */
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

    /**
     * @param $array
     * @param $month
     * @return array
     *
     * Returnerer at array med alle postene i en gitt måned
     */
    static function getMonthArray($array, $month) {
        $monthArray = array();

        foreach ($array as $post) {
            if ((new DateTime($post["postdate"]))->format('m') == $month) {
                $monthArray[] = $post;
            }
        }

        return $monthArray;
    }

    /**
     * @param $numMonth
     * @return string
     *
     * Tar inn en måned på nummerformat og retunrere det norske navnet
     */
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
