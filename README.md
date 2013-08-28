clasik
======

A tentative for browsing the classical musique

Extracting the data from the postGresql database MusicBrainz
  
    select id as artistId, name, trackId, title
    from musicbrainz.artist_name as names
    inner join(

    select titles.trackId, credits.name as artist, titles.title 
    from musicbrainz.artist_credit as credits
    inner join (

    select tracks.id as trackId, tracks.artist_credit as credit, titles.title
    from musicbrainz.track as tracks
    inner join musicbrainz.aaa_titles as titles 
    on tracks.name = titles.id) 
    titles

    on titles.credit = credits.id
    ) credits

    on names.id = credits.artist

Main transformation with sed scripts
  
Checking if the JSON is correct  
	node -e "console.log(JSON.stringify(JSON.parse(require('fs') .readFileSync(process.argv[1])), null, 4));" titles.json
  
Secondary transformation with sed script for producing JSON
  (echo "{"; echo '"titles": [ '; sed -f transform.sed titles.txt.sed | head -2000; echo "{}"; echo "]"; echo "}") >  titles.json

