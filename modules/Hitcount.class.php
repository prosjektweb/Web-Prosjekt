<?php

class Hitcount {

    static function doHitcount($page, $file){

        if(hitcount::siteExsist($page, $file)){
            hitcount::increaseCount($page, $file);
        }
        else{
            hitcount::addSite($page, $file);
            hitcount::increaseCount($page, $file);
        }

    }

    static function getHitcount($page, $file){

        if(hitcount::siteExsist($page, $file)){

            $stmt = getDB()->prepare("SELECT * FROM Pages WHERE page=:page and file=:file;");
            $stmt->execute(array(
                "page" => $page,
                "file" => $file
            ));

            return $stmt->fetch()["hit_count"];
        }
        else{
            hitcount::addSite($page, $file);

            $stmt = getDB()->prepare("SELECT * FROM Pages WHERE page=:page and file=:file;");
            $stmt->execute(array(
                "page" => $page,
                "file" => $file
            ));

            return $stmt->fetch()["hit_count"];
        }


    }

    private static function addSite($page, $file){
        $stmt = getDB()->prepare("INSERT INTO Pages (page, file, hit_count) VALUES (:page, :file, '0')");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file
        ));
    }

    private static function increaseCount($page, $file){

        $stmt = getDB()->prepare("UPDATE Pages SET hit_count = Pages.hit_count + 1 where page=:page and file=:file");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file
        ));

    }

    private static function siteExsist($page, $file){
        $stmt = getDB()->prepare("SELECT * FROM Pages WHERE page=:page and file=:file;");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file
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