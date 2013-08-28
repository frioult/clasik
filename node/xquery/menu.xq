let $return :=
	let $fileName := '/var/www/rioultf/git/clasik/node/data/menu.json'
	let $file := file:read-text($fileName)
	for $json in json:parse($file)//value
		return <menu>{($json/name, $json/label)}</menu>
	
	return element{'json'}{$return}
