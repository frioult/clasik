A tentative for browsing the classical musique

### Extracting the data from the postGresql database MusicBrainz
    select id as artistId, name, trackId, title 
    from musicbrainz.artist_name as names 
    inner join(
        select titles.trackId, credits.name as artist, titles.title 
        from musicbrainz.artist_credit as credits 
        inner join (
            select tracks.id as trackId, tracks.artist_credit as credit, titles.title 
            from musicbrainz.track as tracks 
            inner join musicbrainz.aaa_titles as titles 
            on tracks.name = titles.id) titles
        on titles.credit = credits.id ) credits

    on names.id = credits.artist
### Filter the russian names
See https://github.com/frioult/clasik/blob/master/filter/filter-russ.sed.
### Main transformation with sed script
    php index.php titles.txt | sed -f filter.sed > titles.txt.sed
### Secondary transformation with sed script for producing JSON 
    (echo "{"; echo '"titles": [ '; sed -f transform.sed titles.txt.sed | head -2000; echo "{}"; echo "]"; echo "}") > titles.json

### Checking if the JSON is correct is done with `node.js`:
    node -e "console.log(JSON.stringify(JSON.parse(require('fs') .readFileSync(process.argv[1])), null, 4));" titles.json

### Filtering the bad format lines
We use a shell script, that removes lines from a copy of the input and stores the track id in the `.remove` file :
    #!/bin/bash

    if [ $# -ne 1 ]; then
        ec  ho "erreur usage: $0 <JSON file>" 1>&2
        echo "filters the parts of the JSON with incorrect format" 1>&2
        exit 1
    fi

    input=$1; shift

    new=$input.json

    cp $input $new

    # remove list
    remove=$input.remove
    rm $remove 2>/dev/null

    while :; do
        set $(node -e "console.log(JSON.stringify(JSON.parse(require('fs') .readFileSync(process.argv[1])), null, 4));" $new 2>&1 | grep "undefined" | sed 's/.*://') > /dev/null
        if [ $# -eq 0 ]; then
            break
        else
            track=$(sed -n "$1p" $new | sed 's/.*"track":\([0-9]*\).*/\1/')
            echo $track
            echo $track >> $remove
            sed -i $1d $new 
        fi
    done

### Remove the incorrect lines from the .json file:
(takes also a long time)

    cat titles.json.remove | (while read a; do sed -i "/$a/d" titles.json; done)

A much better solution:

    awk -F'|' 'BEGIN{while ((getline < "tracksToBeRemoved.txt") > 0){tab[$1]=1}}{if($3 in tab)next;print}' titles.txt |wc -l

At the end, edit the `titles.json` file to close the JSON delimiters. The result is [here](https://github.com/frioult/clasik/blob/master/data/titles-def.json).

    php ../src/phpfilter/index.php titles.filter | sed -f ../filter/filter.sed > titles.filter1
    (echo "{"; echo '"titles": [ '; sed -f ../filter/transform.sed titles.filter1 ; echo "{}"; echo "]"; echo "}") >  titles.json

### Completing

First extract the raw list of names:

    awk -F'|' '{print $2}' titles.txt | sort -u > Composers.txt

then use the LastFM API for crawling the `yearformed`:

    cat ../data/Composers.txt |(while read line; do echo $line; node lastfm.js "$line"; done) | tee result

The result is poor...

    sed -n 's/.* \(1[6-9][0-9][0-9] .*\)/\1/p' result 
        1841 Antonín Dvořák
        1874 Arnold Schönberg
        1913 Benjamin Britten
        1835 Camille Saint-Saëns
        1906 Dmitri Shostakovich
        1843 Edvard Grieg
        1809 Felix Mendelssohn
        1811 Franz Liszt
        1797 Franz Schubert
        1810 Frédéric Chopin
        1875 Fritz Kreisler
        1845 Gabriel Fauré
        1685 Georg Friedrich Händel
        1874 Gustav Holst
        1803 Hector Berlioz
        1882 Igor Stravinsky
        1945 Jacqueline du Pré
        1865 Jean Sibelius
        1833 Johannes Brahms
        1825 Johann Strauss II
        1918 Leonard Bernstein
        1904 London Symphony Orchestra
        1770 Ludwig van Beethoven
        1781 Mauro Giuliani
        1840 Pyotr Ilyich Tchaikovsky
        1864 Richard Strauss
        1810 Robert Schumann
        1891 Sergei Prokofiev
        1873 Sergei Rachmaninoff
        1798 United States Marine Band


