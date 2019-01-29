<?php
function grab_link($url,$type)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HEADER, $type);
$result = curl_exec($ch);
curl_close($ch);
return $result;
}
function getlist($string1,$type)
{   
	$url= grab_link($string1,1);
	$xml = '<?xml version="1.0" encoding="utf-8"?>
		<playlist version="1"><trackList>';
	$url = str_replace(array("<![CDATA[","]]>","</title>
		<item"),"",$url);
	if($type==0)
	{
		header("Content-Type: application/xml; charset=utf-8");
		preg_match("#<data>(.*?)</data>#is",$url,$xml1);
		$xml2 = trim  ($xml1[0]);
		$data = str_replace(array("<![CDATA[","]]>","</title>
		<item"),"",$xml2);		
		$data1 = explode("<item",$data);
		for($i=1;$i<count($data1);$i++)
		{
			preg_match("#<title>(.*?)</title>#is",$data1[$i],$temp);
			$creator = str_replace(array("<title>","</title>"),"",$temp[0]);
		
			preg_match("#<singer>(.*?)</singer>#is",$data1[$i],$temp);		
			$title = str_replace(array("<singer>","</singer>"),"",$temp[0]);
		
			$xml .= '<track><title><![CDATA['.$title.']]></title><creator><![CDATA['.$creator.']]></creator>';		
		
			preg_match("#<source>(.*?)</source>#is",$data1[$i],$temp);
			$temp = str_replace(array("<source>","</source>"),"",$temp[0]);
			$xml .= '<location><![CDATA['.$temp.']]></location>'.'<info><![CDATA[http://mp3.zing.vn/tim-kiem/bai-hat.html?q='.$title.'&search_sort=created_date&t=artist]]></info>';
			$xml .= '</track>';
		}
    }
	else
	{
		preg_match("#<title>(.*?)</title>#is",$url,$temp);
		$creator = str_replace(array("<title>","</title>"),"",$temp[1]);
		
		preg_match("#<performer>(.*?)</performer>#is",$url,$temp);		
		$title = str_replace(array("<performer>","</performer>"),"",$temp[0]);
		
		$xml .= '<track><annotation>'.$creator.' - '.$title.'</annotation><title>'.$title.'</title><creator>'.$creator.'</creator>';		
		preg_match("#<source>(.*?)</source>#is",$url,$temp);
		$temp = str_replace(array("<source>","</source>"),"",$temp[0]);
		$xml .= '<location>'.$temp.'</location>';
		$xml .= '</track>';
	}
	$xml .= '</trackList>
					</playlist>';
	return $xml;
}
	$url= grab_link($_GET['id'],0);
	preg_match('#video-clip#is',$_GET['id'],$test);
	if($test[0] == 'video-clip')
	{
		preg_match("#file=(.*?)autostart#is",$url,$xml1);
		$kq = str_replace(array("file=","?autostart","&xmlURL=&autostart"),"",$xml1[0]);
		$type = 1;
	}
	else
	{
		preg_match("#xmlURL(.*?)autostart#is",$url,$xml1);
		$kq = str_replace(array("xmlURL=","&autostart"),"",$xml1[0]);
		$type = 0;
	}
    echo getlist($kq,$type);
?>