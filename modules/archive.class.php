<?php
/**
 * Created by PhpStorm.
 * User: Andreas E. Mosvoll
 * Date: 05.05.2015
 * Time: 17:44
 */

class archive {

    static function generateArchive($array, $datetime){
        $month = $datetime->format(m);
        foreach($array as $post){
            if($post->getPostDate()->format(m) == $month){
                $test = 0;
            }
        }
    }
}