<?php

class Hitcount {

    static function doHitcount($page, $file, $arg_0){

        if(hitcount::siteExsist($page, $file, $arg_0)){
            hitcount::increaseCount($page, $file, $arg_0);
        }
        else{
            hitcount::addSite($page, $file, $arg_0);
            hitcount::increaseCount($page, $file, $arg_0);
        }

    }

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

    private static function addSite($page, $file, $arg_0){
        $stmt = getDB()->prepare("INSERT INTO Pages (page, file, hit_count, arg_0) VALUES (:page, :file, '0', :arg_0)");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file,
            "arg_0" => $arg_0
        ));
    }

    private static function increaseCount($page, $file, $arg_0){

        $stmt = getDB()->prepare("UPDATE Pages SET hit_count = Pages.hit_count + 1 where page=:page and file=:file and arg_0=:arg_0");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file,
            "arg_0" => $arg_0
        ));

    }

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