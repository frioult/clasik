#!/bin/bash

if [ $# -ne 1 ]; then
    echo "erreur usage: $0 <JSON file>" 1>&2
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