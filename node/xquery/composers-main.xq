let $artists := doc('/var/www/rioultf/git/clasik/node/data/artists.xml')/clasix/artist[count>20]

return element{'json'}{

let $composers := doc('/var/www/rioultf/git/clasik/data/composers.xml')//composer
for $artist in $artists
  let $composer := $composers[shortname=$artist/name]
	return <artist>
		{$artist/id, $composer/shortname, $composer/firstname, $composer/lastname, $artist/name, $artist/count}
	</artist>

}
