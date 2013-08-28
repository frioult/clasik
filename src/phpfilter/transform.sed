#!/bin/sed

# second transformation of the tagged file
# --------> sed -f transform.sed titles.txt.sed

s/Дмитрий Дмитриевич Шостакович/Dmitri Chostakovitch/
#s/artistname:   track:/artistname:Dmitri Chostakovitch track:/

s/ artistname:\(.*\) track:/, "artistname":"\1", "track":/
s/indication:\(.*\)/"indication":"\1",/

s/,  part:/ part:/
s/ ,  opus:/ opus:/

s/title:\(.*\) numero:/"titledef":"\1", "numero":/
s/title:\(.*\) tonality:/"titledef":"\1", "tonality":/
s/title:\(.*\) opus:/"titledef":"\1", opus:/

s/ "titledef":/, "title":/
s/tonality:\([a-g]\) /"tonality":"\1", /

# JSON
s/^artist/{"artist"/
s/"numero":[0-9]*/&,/
s/part:[0-9]*/&,/
s/part:/"part":/
s/opus:[0-9]*/&,/
s/mode:major/"mode":"major",/
s/mode:minor/"mode":"minor",/

s/alteration:flat/"alteration":"flat",/
s/alteration:sharp/"alteration":"sharp",/

s/opus:/"opus":/

s/ "/"/g
s/  / /g




s/, *$//
s/$/},/

s/ nr . ) number:/", "numero":/
s/nr . ) number:/"opusnumber":/
s/ es -dur"/, "tonality":"s", "mode":"major"/
s/ cis -moll"/, "tonality":"c", "alteration":"sharp", "mode":"major"/
s/ the year number:[0-9]* *//g
#s/the year number//g
s/ leningrad //
s/ babi yar //
s/ , adagio - doppio movimento - tempo primo /"indication":"adagio - doppio movimento - tempo primo"/
s/ pathétique //
s/, no . number) /, "number"/
s/, no . ) number/, "number"/
s/ moonlight/,/
s/ appassionata/,/
s/ pastoral //
s/,"indication":$//
s/ mondscheinsonate /,/
s/, pastorale //
s/"opus":\([0-9]*\)"/"opus":\1,"/
s/"opus":106, hammerklavier "part"/"opus":106,"part"/
s/tempest "part"/,"part"/
s/ fate "part"/,"part"/

s/ spring "part"/"part"/
s/ pastorale "part"/"part"/
s/ eroica "part"/"part"/
s/moonlight sonata"opus":27,",/moonlight sonata","opus":27,/
s/ , op . )81a les adieux //

s/"tonality":\([a-g]\)"/"tonality":"\1","/
s/, , adagio cantabile /,"indication":"adagio cantabile"/
s/"number":\([0-9]*\) "part"/"number":\1,"part"/
s/, , ouvertüre . )sostenuto , ma non troppo allegro /,"indication":"ouvertüre - sostenuto, ma non troppo allegro"/


/:3535375/d
/1419258/d
/1419259/d
/1419260/d
/1423268/d

/141223[56]/d

/1307409/d
/13074[1-4]/d
/133128[0167]/d
/140663[13]/d

/5733201/d
/5733202/d
/7620900/d
/1230331[01]/d
/12303311/d
/13041421/d
/13041422/d
/12197942/d
/12197943/d
/424028/d
/424029/d

/11221219/d
/1394865[2-4]/d
/11221236/d
/d11221219/d
/11221202/d
/11221237/d
/11221220/d
/11221203/d
/11221204/d
/11221221/d
/11221238/d

/1120603[5-9]/d
/100193[012][0-9]/d
/1001926[7-9]/d
/10019266/d
/10019265/d
/9882606/d
/988260[2-5]/d
/8264623/d
/8143006/d
/7757467/d
/7497129/d
/6692896/d
/6692895/d
/6692894/d
/6632624/d
/6632625/d
/6632639/d
/6632626/d
/6632640/d
/6632627/d
/6632641/d
/6632628/d
/6632638/d
/6632637/d
/6332328/d
/6332317/d
/579140[3-7]/d

s/,,//
