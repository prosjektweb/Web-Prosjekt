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

    private static function addSite($page, $file){
        $stmt = getDB()->prepare("INSERT INTO Pages (page, file, hit_count) VALUES (:page, :file, '0')");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file
        ));
    }

    private static function increaseCount($page, $file){
        $stmt = getDB()->prepare("SELECT hit_count FROM Pages where page=:page and file=:file");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file
        ));

        $hitcount = $stmt->fetch()["hit_count"] + 1;

        $stmt = getDB()->prepare("UPDATE Pages SET hit_count=:hitcount WHERE page=:page and file=:file;");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file,
            "hitcount" => $hitcount
        ));


    }

    private static function siteExsist($page, $file){
        $stmt = getDB()->prepare("SELECT * FROM Pages where WHERE page=:page and file=:file;");
        $stmt->execute(array(
            "page" => $page,
            "file" => $file
        ));

        if($stmt->fetch() == false){
            return false;
        }
        else{
            return true;
        }
    }
}