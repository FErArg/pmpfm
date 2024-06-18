#!/bin/bash 

# Constantes
fileDownload="../youtubeLinks.db"

cd audios-tmp

while IFS= read -r line; do
    # Extract name from video
	filename=$(yt-dlp --get-filename $line)
	filename="${filename//.webm}"
	filename=$(echo $filename | sed 's/[^a-zA-Z0-9]/_/g')
	filename=$(echo $filename | sed 's/__/_/g')

	# Extract audio from youtube video
    #yt-dlp --no-part --no-overwrites --ignore-errors --abort-on-error --restrict-filenames --extract-audio --audio-format mp3 --audio-quality 0 $line
	yt-dlp --extract-audio --audio-format mp3 -o $filename $line

    # check if file exist and move to audio
	FILE="$filename.mp3"
	if [ -f "$FILE" ]; then
		echo "$FILE exists."
		mv $FILE ../audios/

		# Remove video link line from archive
		grep -v $line $fileDownload > tmpfile && mv tmpfile $fileDownload
	else 
		echo "$FILE does not exist."
	fi

done < $fileDownload

cd ..