<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function process($globalPat, $repeatPat, $page, $debug = 0) {
    /*

     * Generates matches from the page using repeatable pattern     
     */

    if ($globalPat == '' || $repeatPat == '')
        return null;

    $globalPage = '';


    if ($globalPat === "/(.*?)/s") {
        $globalPage = $page;
    } else {
        preg_match($globalPat, $page, $tmpPage);
        $globalPage = $tmpPage[0];
    }

    //echo $globalPat . "------" . $repeatPat;
    
    $it_count = preg_match_all($repeatPat, $globalPage, $matches, PREG_SET_ORDER);
    if ($debug == 1) {
        echo $index . '. No. of Items Found:' . $it_count . '<br>';
        echo '<br> ---------- <br>';

        foreach ($matches as $match) {
            foreach ($match as $key => $val) {
                if (strpos($key, 'h') !== FALSE) {
                    echo '<strong>{' . $key . '}</strong> : ' . $val . '<br>';
                }
            }
            echo '<br> ---------- <br>';
        }

        //echo 'No. of occurances:' . $it_count . '<br>';
    }
    return $matches;
}

function cleanPat($pattern, $flag = 0) {
    /*

     * Clean Pattern, so as to create REGEX from {h} & {i}   
     * flag 1 and 0 means global and repeatable pattern respectively 
     */

    $hCount = '';
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

/* To create XML DOM for RSS ... */

function print_xml_item($match, $itTitle, $itDescription, $itLink, $itDate, $channel) {
    /*

     * $match = array containing elements to be printed
     * $it* = Item creation (containing {h*}) format     */

    $itCount = count($match);
//var_dump( $itTitle);
    $tmpTitle = $itTitle;
    $tmpDesc = $itDescription;
    $tmpLink = $itLink;
    if ($itDate == '')
        $tmpDate = date("d M Y - h:i:s A");
    else
        $tmpDate = $itDate;

    $itTitle = cleanItemPat($itTitle);
    $itDescription = cleanItemPat($itDescription);
    $itLink = cleanItemPat($itLink);
    $itDate = cleanItemPat($itDate);

    $titleCount = count($itTitle);
    $descCount = count($itDescription);
    $linkCount = count($itLink);
    $dateCount = count($itDate);

    //echo '<br>------BELOW-----<br>';

    for ($j = 0; $j < $itCount; $j++) {//Traverse the $match array
        $title = $tmpTitle;
        $description = $tmpDesc;
        $link = $tmpLink;
        $date = $tmpDate;

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
        for ($i = 0; $i < $dateCount; $i++) {
            $date = str_replace('{' . $itDate[$i] . '}', $match[$j][$itDate[$i]], $date);
        }

        $item = $channel->addChild('item');

        $item->addChild('title', $title);
        $item->addChildWithCDATA('description', $description);
        $item->addChild('link', $link);
        $item->addChild('pubDate', $date);
        $guid = $item->addChild('guid', feedCreateGuid($filename, $title . $description . $link));
        $guid->addAttribute('isPermalink', 'false');
        //echo $j . ' ---= ' . $title . '   =   ' . $description . '   =   ' . $link . '   =   ' . $date . '<br>';
    }
    // echo '<br>------END-----<br>';

    return $channel->asXML();
}

function feedCreateGuid($filename, $string) {
    /*

     * A function to create GUID for RSS Feed elements.
     * In our case, we append md5 hash of  title,description,link of an item,
     * concatenated to each other in series, to the filename of the xml file
     * 
     *              */
    return $filename . md5($string);
}



function cleanItemPat($item) {
    /* A function to return array containing h1, h2, h3.. for given item */
    //var_dump($item) . "<br>";
    preg_match_all('/\{(h.)\}/s', $item, $item);
    $tmp = '';
    $tmp = $item[1];


    return $tmp;
}

/* Function to get file contents from a given url & return content in UTF-8 */

function file_get_contents_utf8($url) {
    $content = file_get_contents($url);
    return htmlentities(str_replace('&nbsp;', ' ', mb_convert_encoding($content, 'HTML-ENTITIES', mb_detect_encoding($content))));
}

/* SimpleXML Extended to support CDATA for Description etc.. */

class SimpleXMLExtended extends SimpleXMLElement {

    public function addChildWithCDATA($name, $value = NULL) {
        $new_child = $this->addChild($name);

        if ($new_child !== NULL) {
            $node = dom_import_simplexml($new_child);
            $no = $node->ownerDocument;
            $node->appendChild($no->createCDATASection($value));
        }

        return $new_child;
    }

}
