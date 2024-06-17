#!/bin/bash 
podcast_name="FErArg RSS PodCast feed"
podcast_description="Podcast FErArg"
podcast_link="https://www.ferarg.es"
podcast_image="https://www.ferarg.es/images/logo.png"
podcast_language="es-ES"
podcast_xml="https://www.ferarg.com/podcast.xml"
podcast_directory="https://www.ferarg.com/"
dominio="https://www.ferarg.com"
dominioAudios="$dominio/audios"

# Create RSS feed - XML 
echo '<?xml version="1.0" encoding="UTF-8" ?>' > blog.xml
echo '<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:googleplay="https://www.google.com/schemas/play-podcasts/1.0" xmlns:atom="https://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss" version="2.0" xml:lang="es-es">' > blog.xml
echo '<channel>' >> blog.xml 
echo "<title>$podcast_name</title>" >> blog.xml 
echo "<link>$podcast_link</link>" >> blog.xml 
echo "<description>$podcast_description</description>" >> blog.xml 
echo '<image>' >> blog.xml 
	echo "<url>$podcast_image</url>" >> blog.xml 
	echo '<title>$podcast_name</title>' >> blog.xml 
	echo "<link>$podcast_link</link>" >> blog.xml 
echo '</image>' >> blog.xml 
echo "<language>$podcast_language</language>" >> blog.xml 
echo "<atom:link href=\"$podcast_xml\" rel=\"self\" type=\"application/rss+xml\"/>" >> blog.xml 


# Directory containing MP3 posts posts_directory="/audios" 
for filename in "audios"/*.mp3; 
do 
	if [ -f "$filename" ]; 
	then 
		post_id="${filename//audios}"
		post_id="${post_id///}"
		post_id="${post_id//.mp3}"
		post_description="EMPTY"
		
		# Get MP3 length
		post_length=$(mp3info -p "%S\n" $filename | awk 'BEGIN { s = 0 }; { s = s + $1 }; END { print s }')
		
		# get MP3 creation date and is used as publication date
		#post_pubdate=$(date -r $filename "+%m-%d-%Y %H:%M:%S")
		post_pubdate=$(date -r $filename)
		
		# Add the posts to the XML file 
		echo '<item>' >> blog.xml 
			echo "<title>$post_id</title>" >> blog.xml 
			echo "<link>$podcast_directory</link>" >> blog.xml 
			echo "<enclosure url=\"$podcast_directory/$filename\" type=\"audio/mpeg\" length=\"$post_length\"/>" >> blog.xml 
			echo "<description>$post_description<description>" >> blog.xml 
			echo "<pubDate>$post_pubdate</pubDate>" >> blog.xml 
		echo '</item>' >> blog.xml 
	fi 
done 
	
# Close the RSS feed 
echo '</channel>' >> blog.xml 
echo '</rss>' >> blog.xml 

echo 'RSS blog feed generated successfully.' 

