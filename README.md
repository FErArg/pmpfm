# pmpfm
Poor Man Podcast Feed Maker

Solución simple para generar un Feed de Podcast de videos que interese escuchar como podcast


Como funciona - SIMPLIFICADO

- En el archivo youtubeLinks.db se almacena el listado de vídeos de Youtube a descargar

- El script yt-podcast-01.sh descarga el audio en formato MP3 del vídeo, mueve el archivo MP3 al directorio audios y actualiza el listado de videos a descargar youtubeLinks.db

- El script yt-podcast-02.sh genera un XML de feed de podcast


# Pendiente

- Web para incorporar nuevos enlaces al listado youtubeLinks.db
- Generar resumen del audio para incorporar como descripción del "capítulo"


# Soft necesario
- sudo apt-get install youtube-dl OR pip install youtube-dl
- sudo apt-get install mp3info
- Install phantomjs
	- sudo apt-get install build-essential chrpath libssl-dev libxft-dev
	- sudo apt-get install libfreetype6 libfreetype6-dev libfontconfig1 libfontconfig1-dev
	- wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2
	- sudo tar xvjf phantomjs-2.1.1-linux-x86_64.tar.bz2 -C /usr/local/share/
	- sudo ln -sf /usr/local/share/phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/local/b