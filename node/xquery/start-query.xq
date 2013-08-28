let $fileName := '/home/rioultf/git/clasik/data/titles-def.json'
let $file := file:read-text($fileName)

for $json in json:parse($file)
return $json//value