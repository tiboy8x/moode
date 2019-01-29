    <?php
    $userid = 'meo4.info'; // tai khoan pisaca
    $album = 'M4F'; // Ten album pisaca
     $feedURL = "http://picasaweb.google.com/data/feed/api/user/$userid/album/$album?imgmax=600";
    $sxml = simplexml_load_file($feedURL);
	echo "<playData><viewItem type=\"template\" tempType=\"temp3D\" stratTime=\"0\" duration=\"-1\"><dataInfo id=\"0\" size=\"107051\" url=\"res/hemicycle_out.swf\" /></viewItem>	\n" ;
	foreach ($sxml->entry as $entry) {
	  $title = $entry->title;
      $summary = $entry->summary;
      $gphoto = $entry->children('http://schemas.google.com/photos/2007');
      $size = $gphoto->size;
      $height = $gphoto->height;
      $width = $gphoto->width;
      
      $media = $entry->children('http://search.yahoo.com/mrss/');
      $thumbnail = $media->group->thumbnail[1];
      $content = $media->group->content;
	  $tags = $media->group->keywords;
	echo "<viewItem type=\"image\" stratTime=\"4\" duration=\"4\"><dataInfo url=\"";
	echo $content->attributes()->{'url'};
	echo "\" />";
	echo "</viewItem>";
	echo "\n";}
	echo "</playData>";
	?>