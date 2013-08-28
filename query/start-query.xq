let $return :=
	let $fileName := '/home/rioultf/git/clasik/data/titles-def.json'
	let $file := file:read-text($fileName)
	for $json in json:parse($file)//value
		return $json
	
	return element{'json'}{$return}
