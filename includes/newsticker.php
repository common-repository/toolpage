<ul id="js-news" class="js-hidden">
<?php
$myrss = grabRss('http://www.make23.com/feed/');
for($i=0;$i<=(sizeof($myrss)-1);$i++){
?>
    <li class="news-item"><a href="<?php echo $myrss[$i]['link']; ?>" title="<?php echo $myrss[$i]['title']; ?>" target="_blank"><?php echo $myrss[$i]['title']; ?></a></li>
<?php
}
?>
</ul> 