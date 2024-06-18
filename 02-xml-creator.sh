#!/bin/bash 
# Crea XML -------------------------------------------------------------

# Constantes
audios="/var/www/html/podcast/audios"
podcast_name="FErArg's PodCast"
podcast_description="Podcast FErArg con cositas variadas"
podcast_link="https://www.ferarg.com"
podcast_email="ferarg@ferarg.com"
podcast_image="https://www.ferarg.com/logo.png"
podcast_language="es-ES"
podcast_xml="https://www.ferarg.com/podcast/podcast.xml"
podcast_directory="https://www.ferarg.com/podcast/audios"
podcast_file="/var/www/html/podcast/podcast.xml"

rm $podcast_file
touch $podcast_file

# Create RSS feed - XML
echo '<?xml version="1.0" encoding="UTF-8" ?>' >> $podcast_file
echo '<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:googleplay="https://www.google.com/schemas/play-podcasts/1.0" xmlns:atom="https://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss" version="2.0" xml:lang="es-es">' >> $podcast_file
echo "<channel>" >> $podcast_file
echo "<title>$podcast_name</title>" >> $podcast_file
echo "<itunes:owner>" >> $podcast_file
echo "<itunes:email>$podcast_email</itunes:email>" >> $podcast_file
echo "</itunes:owner>" >> $podcast_file
echo "<itunes:author>FErArg</itunes:author>" >> $podcast_file
echo "<description>$podcast_description</description>" >> $podcast_file
echo "<itunes:image href=\"$podcast_image\" />" >> $podcast_file
echo "<language>$podcast_language</language>" >> $podcast_file
echo "<link>$podcast_link</link>" >> $podcast_file
echo "<itunes:category text=\"Various\">" >> $podcast_file
echo "<itunes:category text=\"Personal\"/>" >> $podcast_file
echo "</itunes:category>" >> $podcast_file
echo "<itunes:explicit>false</itunes:explicit>" >> $podcast_file
echo "<url>$podcast_image</url>" >> $podcast_file
echo '<image>' >> $podcast_file
echo "<url>$podcast_image</url>" >> $podcast_file
echo '</image>' >> $podcast_file
echo "<atom:link href=\"$podcast_xml\" rel=\"self\" type=\"application/rss+xml\"/>" >> $podcast_file
echo "" >> $podcast_file




# Directory containing MP3 posts posts_directory="/audios" 
cd $audios
for filename in *.mp3;
do
        if [ -f "$filename" ];
        then
                post_id="${filename//$audios}"
                post_id="${post_id///}"
                post_id="${post_id//.mp3}"
                post_id=$(echo $post_id | tr "_" " ")
                post_description="EMPTY"

                # Get MP3 length
                post_length=$(mp3info -p "%S\n" $filename | awk 'BEGIN { s = 0 }; { s = s + $1 }; END { print s }')

                # get MP3 creation date and is used as publication date
                post_pubdate=$(LC_ALL=en_EN date -r $filename  +"%a, %d %b %Y %H:%M:%S GMT")

                # Add the posts to the XML file
                echo '<item>' >> $podcast_file
                echo "<title>$post_id</title>" >> $podcast_file
                echo "<itunes:episodeType>fulltrailer</itunes:episodeType>" >> $podcast_file
                echo "<itunes:title>$post_id</itunes:title>" >> $podcast_file
                echo "<description>$post_description</description>" >> $podcast_file
                echo "<enclosure url=\"$podcast_directory/$filename\" type=\"audio/mpeg\" length=\"$post_length\"/>" >> $podcast_file
                echo "<guid></guid>" >> $podcast_file
                echo "<pubDate>$post_pubdate</pubDate>" >> $podcast_file
                echo "<itunes:duration>$post_length</itunes:duration>" >> $podcast_file
                echo "<itunes:explicit>true</itunes:explicit>" >> $podcast_file
                echo '</item>' >> $podcast_file
        fi
done

# Close the RSS feed
echo '</channel>' >> $podcast_file
echo '</rss>' >> $podcast_file

echo 'RSS Podcast feed generated successfully. -=<FErArg>=-'

chown www-data:www-data -R /var/www/htmlfile new code and path/podcast


