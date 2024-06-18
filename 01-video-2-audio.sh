#!/bin/bash
. /root/scripts/./funciones.lib

#Constantes
fileDownload="/var/www/html/youtubeLinks.db"
audios_tmp="/tmp/audios-tmp"
audios="/var/www/html/podcast/audios"
tmpfile="/tmp/yt-download.tmp"

chown www-data:www-data $origen

# mkdir $audios
# mkdir $audios_tmp

cd $audios_tmp

while IFS= read -r line; do
        #echo $line
        filename=$(yt-dlp --get-filename $line)
        filename="${filename//.webm}"
        filename=$(echo $filename | sed 's/[^a-zA-Z0-9]/_/g')
        filename=$(echo $filename | sed 's/__/_/g')

        # extract audio from youtube video
        yt-dlp --extract-audio --audio-format mp3 --output --restrict-filenames -o $filename $line >> $log

        FILE="$filename.mp3"
        if [ -f "$FILE" ]; then
                echo "$FILE exists."
                mv $FILE $audios/

                # remove line from archive
                grep -v $line $fileDownload > $tmpfile && mv $tmpfile $fileDownload
        else
                echo "$FILE does not exist."
        fi
done < $fileDownload

cd $audios
