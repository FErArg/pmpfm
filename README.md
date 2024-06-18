# pmpfm

Poor Man Podcast Feed Maker


# CASTELLANO

Solución simple para generar un Feed de Podcast de videos que interese escuchar como podcast.


## Como funciona - SIMPLIFICADO

- En el archivo youtubeLinks.db almacena el listado de vídeos de Youtube a descargar.

- El script 01-video-2-audio.sh descarga el audio en formato MP3 del vídeo y mueve el archivo MP3 al directorio "audios", a continuación actualiza el listado de videos de youtubeLinks.db.

- El script 02-xml-creator.sh genera un XML de feed de podcast.


# Pendiente

- Web para incorporar nuevos enlaces al listado youtubeLinks.db.
- Generar resumen del audio para incorporar como descripción del "capítulo".


# Directorio

- audios: almacenan los MP3 que se crean desde yt-podcast-01.sh y leen desde para crear el XML desde 02-xml-creator.sh.
- audios-tmp: directorio que utiliza yt-podcast-01.sh como temporal de archivos de descarga.


# Soft necesario

- Web Server (testeado en Apache2)
- youtube-dl
	- https://github.com/yt-dlp/yt-dlp
	- sudo apt-get install youtube-dl OR pip install youtube-dl
- sudo apt-get install mp3info
- Install phantomjs
	- sudo apt-get install build-essential chrpath libssl-dev libxft-dev
	- sudo apt-get install libfreetype6 libfreetype6-dev libfontconfig1 libfontconfig1-dev
	- wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2
	- sudo tar xvjf phantomjs-2.1.1-linux-x86_64.tar.bz2 -C /usr/local/share/
	- sudo ln -sf /usr/local/share/phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/local/bin/

# El archivo "podcast.xml" es solo una ejemplo del resultado de ejecutar el script "02-xml-creator.sh"

---

# ENGLISH

Simple solution to generate a Podcast Feed of videos you are interested in listening to as a podcast


## How it works - SIMPLIFIED

- In the file youtubeLinks.db stores the list of Youtube videos to download.

- The script 01-video-2-audio.sh downloads the audio in MP3 format from the video and moves the MP3 file to the "audios" directory, then updates the list of videos in youtubeLinks.db.

- The script 02-xml-creator.sh generates an XML podcast feed


# Pending

- Web to add new links to the youtubeLinks.db list.
- Generate audio summary to incorporate as "chapter" description


# Directory

- audios: store MP3s that are created from 01-video-2-audio.sh and read from to create the XML from 02-xml-creator.sh
- audios-tmp: directory used by 01-video-2-audio.sh as a temporary download file directory


# Soft required

- Web Server (tested in Apache2)
- youtube-dl
	- https://github.com/yt-dlp/yt-dlp
	- sudo apt-get install youtube-dl OR pip install youtube-dl
- sudo apt-get install mp3info
- Install phantomjs
	- sudo apt-get install build-essential chrpath libssl-dev libxft-dev
	- sudo apt-get install libfreetype6 libfreetype6-dev libfontconfig1 libfontconfig1-dev
	- wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2
	- sudo tar xvjf phantomjs-2.1.1-linux-x86_64.tar.bz2 -C /usr/local/share/
	- sudo ln -sf /usr/local/share/phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/local/bin/

# The "podcast.xml" file is only an example of executing the script "02-xml-creator.sh"