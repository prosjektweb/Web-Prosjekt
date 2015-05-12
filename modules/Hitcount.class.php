<?php

class Hitcount {
    /**
     * @param $page
     * @param $file
     * @param $arg_0
     *
     * Oppdaterer hitcount i database
     */
    static function doHitcount($page, $file, $arg_0){

        if(hitcount::siteExsist($page, $file, $arg_0)){
            hitcount::increaseCount($page, $file, $arg_0);
        }
        else{
            hitcount::addSite($page, $file, $arg_0);
            hitcount::increaseCount($page, $file, $arg_0);
        }

    }

    /**
     * @param $page
     * @param $file
     * @param $arg_0
     * @return mixed
     *
     * Henter hitcount fra database
     */
    static function getHitcount($page, $file, $arg_0){

        if(hitcount::siteExsist($page, $file , $arg_0)){

            $stmt = getDB()->prepare("SELECT * FROM Pages WHERE page=:page and file=:file and arg_0=:arg_0;");
            $stmt->execute(array(
                "page" => $page,
                "file" => $file,
                "arg_0" => $arg_0
            ));

            return $stmt->fetch()["hit_count"];
        }
        else{
            hitcount::addSite($page, $file, $arg_0);

            $stmt = getDB()->prepare("SELECT * FROM Pages WHERE page=:page and file=:file and arg_0=:arg_0;");
            $stmt->execute(array(
                "page" => $page,
                "file" => $file,
                "arg_0" => $arg_0
            ));

            return $stmt->fetch()["hit_count"];
        }


    }

    /**
     * @param $page
     * @param $file
     * @param $arg_0
     *
     * Legger til en ny side i databasen og setter hitcount til 0
     */
    private static function addSite($page, $file, $arg_0){
        $stmt = getDB()->prepare("INSERT INTO Pages (page, file, hit_count, arg_0) VALUES (:page, :file, '0', :arg_0)");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file,
            "arg_0" => $arg_0
        ));
    }

    /**
     * @param $page
     * @param $file
     * @param $arg_0
     *
     * Øker hitcountetn på en gitt side med 1
     */
    private static function increaseCount($page, $file, $arg_0){

        $stmt = getDB()->prepare("UPDATE Pages SET hit_count = Pages.hit_count + 1 where page=:page and file=:file and arg_0=:arg_0");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file,
            "arg_0" => $arg_0
        ));

    }

    /**
     * @param $page
     * @param $file
     * @param $arg_0
     * @return bool
     *
     * returnerer en bool som forteller om siden er i basen eller ikke
     */
    private static function siteExsist($page, $file, $arg_0){
        $stmt = getDB()->prepare("SELECT * FROM Pages WHERE page=:page and file=:file and arg_0=:arg_0;");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file,
            "arg_0" => $arg_0
        ));

        $hitcount = $stmt->fetch()["hit_count"];

        if(isset($hitcount)){
            return true;
        }
        else{
            return false;
        }
    }
}