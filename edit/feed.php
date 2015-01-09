<?php
$filename = $_GET['filename'];
session_start();
?>
<!DOCTYPE html>
<!--

Author: Huzaib Shafi
Author Website: http://www.shafihuzaib.com

The MIT License

Copyright 2014 Huzaib Shafi (http://www.shafihuzaib.com).

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
-->
<?php
include_once '../header.php';
include_once '../db.php';

$query = "SELECT * FROM source WHERE filename = '$filename'"; 
$res = mysqli_query($link,$query);
if(mysqli_errno($link) != 0)
    echo "---";
else{
    $arr = mysqli_fetch_assoc($res);
    $url = $arr['url'];
      
    $g1 = $arr['global1'];
    $r1 = $arr['repeat1'];
    
    $g2 = $arr['global2'];
    $r2 = $arr['repeat2'];
    
    $g3 = $arr['global3'];
    $r3 = $arr['repeat3'];
    
    $g4 = $arr['global4'];
    $r4 = $arr['repeat4'];
    
    
}
echo $g1;

?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#url-form").submit(function() {
            return submitForm("#url-form", "submit.php?q=urlform&filename=<?php echo $filename; ?>", "#raw-data-url", "#loadingurl");

        });

        $("#pattern-form").submit(function() {
            return submitForm("#pattern-form", "submit.php?q=patternform&filename=<?php echo $filename; ?>", "#raw-data-pattern", "#loadingpattern");

        });
        $("#config-form").submit(function() {

            return submitForm("#config-form", "submit.php?q=configform&filename=<?php echo $filename; ?>", "#raw-data-config", "#loadingconfig");

        });

    });
</script> 


<form  method="POST" id="url-form"  action="#">
    <input size="80" placeholder="Enter url" type="text" name = "url" value="<?php echo $url; ?>" />
    <input size="10" placeholder="Encoding Type" type="text" name = "encoding" />
    <input type="submit" id="urlform"   />
    <div id ="loadingurl">Loading</div>
</form>

<div align="center">
    <div id="raw-data"><div id="raw-data-url"></div>

    </div>

</div>

<div class="feed-config">
    <form id="pattern-form" method="POST" action="#">
        <pre>
    <textarea placeholder="Enter global pattern 1" name="out_pattern1" ><?php echo $g1; ?></textarea><textarea placeholder="Enter repeatable pattern 1" name = "pattern1"><?php echo $r1; ?></textarea>
    <textarea placeholder="Enter global pattern 2" name="out_pattern2"><?php echo $g2; ?></textarea><textarea placeholder="Enter repeatable pattern 2" name = "pattern2"><?php echo $r2; ?></textarea>
    <textarea placeholder="Enter global pattern 3" name="out_pattern3"><?php echo $g3; ?></textarea><textarea placeholder="Enter repeatable pattern 3" name = "pattern3"><?php echo $r3; ?></textarea>
    <textarea placeholder="Enter global pattern 4" name="out_pattern4"><?php echo $g4; ?></textarea><textarea placeholder="Enter repeatable pattern 4" name = "pattern4"><?php echo $r4; ?></textarea>
    <input type="hidden" value="" name = "url">
    <input type="submit" />
</form>
<div align="center"><div id="loadingpattern">Loading</div>
<div id="raw-data"><div id="raw-data-pattern"></div></div></div>







    <h2>Feed Configuration</h2>
<form method="post" action="" id="config-form">
    <input size="80"  type='text' name='feedTitle' placeholder="Title of the feed" value="<?php echo $arr['feedtitle']; ?>" />
    <input size="80"  type='text' name='feedDesc' placeholder="Description of the feed" value="<?php echo $arr['feeddesc']; ?>" />
    <input  size="80" type='text' name='feedLink' placeholder="Link of the feed" value="<?php echo $arr['feedurl']; ?>" />


    <h2>Feed Item Configuration</h2>
    <input  size="80" type='text' name='title' placeholder="Title of the item" value="<?php echo $arr['itemtitle']; ?>" />
    <input  size="80" type='text' name='description' placeholder="Description of the item" value="<?php echo $arr['itemdesc']; ?>" />
    <input size="80"  type='text' name='link' placeholder="Link of the item" value="<?php echo $arr['itemurl']; ?>" />
    <input size="80"  type='text' name='date' placeholder="Publishing Date of the item - Leave Blank if not sure" value="<?php echo $arr['itemdate']; ?>" />
    
    <div align="center"><div id="loadingconfig">Loading</div>
  <input type="submit" /></form>
</pre>

<div id="raw-data"><div id="raw-data-config"></div></div></div>
</div>





</body>
</html>
