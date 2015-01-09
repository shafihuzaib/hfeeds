<?php

/*

 * Author: Huzaib Shafi
 * Author Website: http://www.shafihuzaib.com

 * The MIT License
 *
 * Copyright 2014 Huzaib Shafi (http://www.shafihuzaib.com).
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

$dbName = 'hfeeds';
$dbUser = 'root';
$dbPass = '';
$dbHost = 'localhost';

$link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (mysqli_connect_errno($link))
    die("mysql cannot connect" . mysqli_connect_error($link));
$r1 = str_replace("'\'", '\\', $r1);

function dbSave($filename, $url, $feedTitle, $feedDesc, $feedUrl, $itTitle, $itDescription, $itLink, $itDate, $g1, $r1, $g2, $r2, $g3, $r3, $g4, $r4) {
    /*
     *   
     */
    global $link;

    $insert = "INSERT INTO `source` ("
            . "`filename`, `url`, `feedtitle`, `feeddesc`, `feedurl`, `itemtitle`, `itemdesc`, `itemurl`, `itemdate`, `global1`, `repeat1`, `global2`, `repeat2`, `global3`, `repeat3`, `global4`, `repeat4`"
            . " ) values ("
            . "'$filename', '$url', '$feedTitle', '$feedDesc', '$feedUrl', '$itTitle', '$itDescription', '$itLink', '$itDate', '$g1','$r1', '$g2', '$r2', '$g3', '$r3', '$g4', '$r4'"
            . ");";
    $update = "UPDATE `source` SET "
            . "`url`='$url',"
            . "`feedtitle`='$feedTitle',"
            . "`feeddesc`='$feedDesc',"
            . "`feedurl`='$feedUrl',"
            . "`itemtitle`='$itTitle',"
            . "`itemdesc`='$itDescription',"
            . "`itemurl`='$itLink',"
            . "`itemdate`='$itDate',"
            . "`global1`='$g1',"
            . "`repeat1`='$r1',"
            . "`global2`='$g2',"
            . "`repeat2`='$r2',"
            . "`global3`='$g3',"
            . "`repeat3`='$r3',"
            . "`global4`='$g4',"
            . "`repeat4`='$r4'"
            . " WHERE `filename`='$filename'";

    mysqli_query($link, $insert);
    if (mysqli_error($link)) {
        mysqli_query($link, $update);
    }
    //echo "Affec::::" . mysqli_affected_rows($link);
    //echo "<br>".$query;
}
