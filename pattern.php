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
include_once 'header.php';


$url = $_POST['url'];
$page = str_replace('\n', ' ', file_get_contents_utf8($url));
$hCount = 0;
$matchFinal = array();

$filename = $_GET['file'];
$file = fopen('./xml/' . $filename . '.xml', w);
echo '<b>Your RSS Feed file is <a href="./xml/' . $filename . '.xml">' . $filename . '.xml' . '</a></b><br>';

fputs($file, '<?php '
        . 'include_once("./default.php");'
        . '$channel->addChild("title","' . $_POST['feedTitle'] . '");'
        . '$channel->addChild("description","' . $_POST['feedDesc'] . '");'
        . '$channel->addChild("link","' . $url . '");'
        . '$url="' . $url . '";'
        . '$page = str_replace("\n", " ", file_get_contents_utf8($url));'
);

$itTitle = $_POST['title'];
$itDescription = $_POST['description'];
$itLink = $_POST['link'];
$itDate = $_POST['date'];

echo '<div align="center"><div id="raw-data">';
if ($_POST['out_pattern1'] != '' and $_POST['pattern1'] != '') {
    $str = '$g1="' . cleanPat(htmlentities($_POST['out_pattern1']), 1)
            . '";$r1="' . cleanPat(htmlentities($_POST['pattern1']))
            . '";$itTitle="' . $_POST['title']
            . '";$itDescription="' . $_POST['description']
            . '";$itLink="' . $_POST['link']
            . '";$itDate="' . $_POST['date']
            . '";print_xml_item(process(1), $itTitle, $itDescription, $itLink, $itDate,$channel);';
    fputs($file, $str);
    $match = process(1);

    print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate);
}
if ($_POST['out_pattern2'] != '' and $_POST['pattern2'] != '') {
    $str = '$g2="' . cleanPat(htmlentities($_POST['out_pattern2']), 1)
            . '";$r2="' . cleanPat(htmlentities($_POST['pattern2']))
            . '";$itTitle="' . $_POST['title']
            . '";$itDescription="' . $_POST['description']
            . '";$itLink="' . $_POST['link']
            . '";$itDate="' . $_POST['date']
            . '";print_xml_item(process(2), $itTitle, $itDescription, $itLink, $itDate,$channel);';
    fputs($file, $str);
    $match = process(2);

    print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate);
}
if ($_POST['out_pattern3'] != '' and $_POST['pattern3'] != '') {
    $str = '$g3="' . cleanPat(htmlentities($_POST['out_pattern3']), 1)
            . '";$r3="' . cleanPat(htmlentities($_POST['pattern3']))
            . '";$itTitle="' . $_POST['title']
            . '";$itDescription="' . $_POST['description']
            . '";$itLink="' . $_POST['link']
            . '";$itDate="' . $_POST['date']
            . '";print_xml_item(process(3), $itTitle, $itDescription, $itLink, $itDate,$channel);';
    fputs($file, $str);
    $match = process(3);

    print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate);
}
if ($_POST['out_pattern4'] != '' and $_POST['pattern4'] != '') {
    $str = '$g4="' . cleanPat(htmlentities($_POST['out_pattern4']), 1)
            . '";$r4="' . cleanPat(htmlentities($_POST['pattern4']))
            . '";$itTitle="' . $_POST['title']
            . '";$itDescription="' . $_POST['description']
            . '";$itLink="' . $_POST['link']
            . '";$itDate="' . $_POST['date']
            . '";print_xml_item(process(4), $itTitle, $itDescription, $itLink, $itDate,$channel);';
    fputs($file, $str);
    $match = process(4);

    print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate);
}

fputs($file, 'echo $xml->asXML(); ?>');
fclose($file);
echo '</div></div>';
function process($index) {
    global $page, $file;

    $globalPat = '';
    $repeatPat = '';
    $globalPage = '';


    switch ($index) {
        case 1:
            $globalPat = htmlentities($_POST['out_pattern1']);
            $repeatPat = htmlentities($_POST['pattern1']);
            break;
        case 2:
            $globalPat = htmlentities($_POST['out_pattern2']);
            $repeatPat = htmlentities($_POST['pattern2']);
            break;
        case 3:
            $globalPat = htmlentities($_POST['out_pattern3']);
            $repeatPat = htmlentities($_POST['pattern3']);
            break;
        case 4:
            $globalPat = htmlentities($_POST['out_pattern4']);
            $repeatPat = htmlentities($_POST['pattern4']);
            break;
        default:
            return(-1);
    }


    if ($globalPat === '{h}') {
        $globalPage = $page;
    } else {
        preg_match(cleanPat($globalPat, 1), $page, $tmpPage);
        $globalPage = $tmpPage[0];
    }


//$globalPat = cleanPat($globalPat, 1);
    $repeatPat = cleanPat($repeatPat);
    //preg_match($globalPat, $page, $tmpPage);



    $it_count = preg_match_all($repeatPat, $globalPage, $matches, PREG_SET_ORDER);


    echo $index . '. No. of Items Found:' . $it_count . '<br>';
    echo '<br> ---------- <br>';

    foreach ($matches as $match) {
        foreach ($match as $key => $val) {
            if (strpos($key, 'h') !== FALSE) {
                echo '<strong>{'.$key.'}</strong> : ' . $val . '<br>';
            }
        }
        echo '<br> ---------- <br>';
    }
    return $matches;
}

function cleanPat($pattern, $flag = 0) {
    global $hCount;
//Escape special characters
    $pattern = str_replace("(", "\\(", $pattern);
    $pattern = str_replace(")", "\\)", $pattern);
    $pattern = str_replace(".", "\\.", $pattern);
    $pattern = str_replace("/", "\\/", $pattern);
    $pattern = str_replace("^", "\\^", $pattern);
    $pattern = str_replace("$", "\\$", $pattern);
    $pattern = str_replace("+", "\\+", $pattern);
    $pattern = str_replace("?", "\\?", $pattern);
    $pattern = str_replace("|", "\\|", $pattern);
    $pattern = str_replace("[", "\\[", $pattern);
    $pattern = str_replace("]", "\\]", $pattern);

//Replace our two special variables {i} & {h}
    $pattern = str_replace("{i}", ".*?", $pattern);

    $hCount = substr_count($pattern, '{h}');
    if ($flag == 0) {
        for ($y = 1; $y <= $hCount; $y++) {
            $pos = strpos($pattern, '{h}');
            $pattern = substr_replace($pattern, '(?P<h' . $y . '>.*?)', $pos, 3);
        }
    } else
        $pattern = str_replace("{h}", "(.*?)", $pattern);

//Escape remaining { & }
    $pattern = str_replace("{", "\\{", $pattern);
    $pattern = str_replace("}", "\\}", $pattern);


// Create Final Perl Regex to be used in PHP
    $pattern = '/' . $pattern . '/s';

    return $pattern;
}

function print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate) {
    $itCount = count($match);

    $itTitle = cleanItemPat($itTitle);
    $itDescription = cleanItemPat($itDescription);
    $itLink = cleanItemPat($itLink);
    if ($itDate != '')
        $itDate = cleanItemPat($itDate);

    $tmpdate = date("d M Y - h:i:s A");
    $titleCount = count($itTitle);
    $descCount = count($itDescription);
    $linkCount = count($itLink);
    $dateCount = count($itDate);



    for ($j = 0; $j < $itCount; $j++) {

        $title = $_POST['title'];
        $description = $_POST['description'];
        $link = $_POST['link'];
        if ($_POST['date'] == '')
            $date = $tmpdate;
        else
            $date = $_POST['date'];

        //For Title
        for ($i = 0; $i < $titleCount; $i++) {

            $title = str_replace('{' . $itTitle[$i] . '}', $match[$j][$itTitle[$i]], $title);
        }
        //For Description
        for ($i = 0; $i < $descCount; $i++) {

            $description = str_replace('{' . $itDescription[$i] . '}', $match[$j][$itDescription[$i]], $description);
        }
        //For Link
        for ($i = 0; $i < $linkCount; $i++) {
            $link = str_replace('{' . $itLink[$i] . '}', $match[$j][$itLink[$i]], $link);
        }
        //For Date
        if ($itDate != '')
            for ($i = 0; $i < $dateCount; $i++) {
                $date = str_replace('{' . $itDate[$i] . '}', $match[$j][$itDate[$i]], $date);
            }

        //echo $j . ' ---= ' . $title . '   =   ' . $description . '   =   ' . $link . '   =   ' . $date . '<br>';
    }
}

/* Function to get file contents from a given url & return content in UTF-8 */

function file_get_contents_utf8($url) {
    $content = file_get_contents($url);
    return htmlentities(str_replace('&nbsp;', ' ', mb_convert_encoding($content, 'HTML-ENTITIES', mb_detect_encoding($content))));
}

/* A function to return array containing h1, h2, h3.. for given item */

function cleanItemPat($item) {
    preg_match_all('/\{(h.)\}/s', $item, $item);
    $item = $item[1];
    return $item;
}

?>
