(: generating the list of composer with their id and count of tracks :)

<root>{
let $fileName := '/var/www/rioultf/git/clasik/node/data/titles-def.json'
let $file := file:read-text($fileName)

let $json := json:parse($file)
let $names := distinct-values($json//value[artistname="anton webern"]/artistname)
for $name in $names
	let $values := $json//value[artistname=$name]
	let $id := data(subsequence($values/artist, 1, 1))
	let $count := count($values)
	
	return <artist>
		<id>{$id}</id>
		<name>{$name}</name>
		<count>{$count}</count>
	</artist>
}</root>