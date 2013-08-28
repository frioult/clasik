let $fileName := '/home/rioultf/git/clasik/data/titles-def.json'
let $file := file:read-text($fileName)

let $json := json:parse($file)
let $names := distinct-values($json//artistname)
for $name in $names
	return <artist>
		<name>{$name}</name>
	</artist>
