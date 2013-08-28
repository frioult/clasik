-- psql -t --no-align <  
\c musicbrainz_db

/*
select ids.id, name
from track_name as t
inner join (select id
     from musicbrainz.track where id > 2251720
     ) ids
on t.id = ids.id
*/

-- id, titre et count des titres apparaissant sur
-- plus de 4 tracks
-- exporty dans titles.txt
-- puis : awk -F'|' '$3>50 && 3450>$3 {print}' titles.txt
/*select t.id, t.name, ids.count
from musicbrainz.track_name as t
inner join (
    select name, count(1) 
    from musicbrainz.track 
    group by name 
    having count(1) > 4 
    order by count(1) desc 
) ids
on t.id = ids.name
where t.name like '%Op.%'
order by ids.count desc*/

/* 5è de Beethoven */
/* select artist_credit from musicbrainz.track where name = 3970323*/
/* select name from artist_credit where id = 1021*/

/*-- select * from artist_name where id = 828955*/

/*
insert into musicbrainz.aaa_titles 
select id + 1 as id, title, count 
from musicbrainz.aaa_titles;
*/

-- insert dans la table des titres
/*insert into musicbrainz.aaa_titles 
select t.id, t.name as title, ids.count
from musicbrainz.track_name as t
inner join (
    select name, count(1) 
    from musicbrainz.track 
    group by name 
    having count(1) > 4 
    order by count(1) desc 
) ids
on t.id = ids.name
where t.name like '%Op.%'
order by ids.count desc*/

-------------------------------------------------------
--- titres - interprêtes
/*select *
from artist_name as names
inner join

(select credits.artist, title
from artist_credit_name as credits
inner join (select credits.name as artist, titles.title 
            from artist_credit as credits
            inner join (select tracks.artist_credit as credit, titles.title
                        from musicbrainz.track as tracks
                        inner join musicbrainz.aaa_titles as titles 
                        on tracks.name = titles.id) titles
             on titles.credit = credits.id) artistes
on credits.artist_credit = artistes.artist)
titles
on titles.artist = names.id
*/

------------ OK ----------------------------------
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
