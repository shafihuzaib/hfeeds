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
session_start();
include('../lib.php');
include '../db.php';

$url= '';



$filename = $_GET['filename'];
if (isset($_SESSION['url']))
    $url = $_SESSION['url'];
if (isset($_SESSION['encoding']))
    $encoding = $_SESSION['encoding'];



$case = $_GET['q'];

switch ($case) {

    case 'urlform':
        $url = $_POST['url'];
        $encoding = $_POST['encoding'];
        echo file_get_contents_utf8($url, $encoding);
        $_SESSION['url'] = $url;
        $_SESSION['encoding'] = $encoding;

        break;

    case 'patternform':
        $page = file_get_contents_utf8($url, $encoding);
        if ($_POST['out_pattern1'] != '' & $_POST['pattern1'] != '') {

            $globalPat = cleanPat(htmlentities($_POST['out_pattern1']), 1);
            $repeatPat = cleanPat(htmlentities($_POST['pattern1']));

            $match = process($globalPat, $repeatPat, $page, 1);
            $_SESSION['g1'] = $globalPat;
            $_SESSION['r1'] = $repeatPat;

            //print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate);
        }

        if ($_POST['out_pattern2'] != '' & $_POST['pattern2'] != '') {

            $globalPat = cleanPat(htmlentities($_POST['out_pattern2']), 1);
            $repeatPat = cleanPat(htmlentities($_POST['pattern2']));

            $match = process($globalPat, $repeatPat, $page, 1);
            $_SESSION['g2'] = $globalPat;
            $_SESSION['r2'] = $repeatPat;

            //print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate);
        }
        if ($_POST['out_pattern3'] != '' & $_POST['pattern3'] != '') {

            $globalPat = cleanPat(htmlentities($_POST['out_pattern3']), 1);
            $repeatPat = cleanPat(htmlentities($_POST['pattern3']));

            $match = process($globalPat, $repeatPat, $page, 1);
            $_SESSION['g3'] = $globalPat;
            $_SESSION['r3'] = $repeatPat;

            //print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate);
        }
        if ($_POST['out_pattern4'] != '' & $_POST['pattern4'] != '') {

            $globalPat = cleanPat(htmlentities($_POST['out_pattern4']), 1);
            $repeatPat = cleanPat(htmlentities($_POST['pattern4']));

            $match = process($globalPat, $repeatPat, $page, 1);
            $_SESSION['g4'] = $globalPat;
            $_SESSION['r4'] = $repeatPat;
        }

        break;

    case 'configform':


        $feedTitle = $_POST['feedTitle'];
        $feedDesc = $_POST['feedDesc'];
        $feedLink = $_POST['feedLink'];


        $itTitle = $_POST['title'];
        $itDescription = $_POST['description'];
        $itLink = $_POST['link']; 

        $itDate = (isset($_POST['date']) && $_POST['date'] != '') ? cleanItemPat($_POST['date']) : date("d M Y - h:i:s A");

        $page = file_get_contents_utf8($url, $encoding);

        $match = process($_SESSION['g1'], $_SESSION['r1'], $page);
        
        $channel = new SimpleXMLExtended("<rss />");
        if($match == null){
            //echo "Both global & repeatable pattern need to be set.";
            return;
        }
        echo print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate, $channel);
        dbSave($filename,$url, $feedTitle, $feedDesc, $feedLink, $itTitle, $itDescription, $itLink, $itDate, $_SESSION['g1'], $_SESSION['r1'], $_SESSION['g2'], $_SESSION['r2'], $_SESSION['g3'], $_SESSION['r3'], $_SESSION['g4'], $_SESSION['r4']);
        session_unset();
        break;
    default:
        echo "There is some error. Please try again after few moments.";
        break;
}
mysqli_close($link);
