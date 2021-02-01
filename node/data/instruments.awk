#!/usr/bin/awk

BEGIN{
    FS = ";"
    instruments = ARGV[--ARGC]
    while ((getline < instruments) > 0)
	tab["\"" $2 "\","] = $1
}

/"title"/{
    print
    split($0, t, ": ")
    if (t[2] in tab)
	print "\"instrument\": \"" tab[t[2]] "\","
    else
	print "\"instrument\": \"orchestra\","
    next
}

{
    print
}
