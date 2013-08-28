#!/bin/sed

# first transformation of the tagged file
# ---------> megaquick:[phpfilter]$ php index.php titles.txt | sed -f filter.sed > titles.txt.sed

s/^number:/artist:/g

#s/separator:PIPE/title:/

s/firstWord:true separator:PIPE/artistname:/g
s/separator:PIPE number:\([0-9]*\) separator:PIPE/track:\1 separator:PIPE/

s/separator:PIPE text:/title:/g

s/text:op separator:DOT number:/opus:/g
s/text:op separator:DOT separator:SPACE number:/opus:/g
s/text:no separator:DOT separator:SPACE number:/numero:/
s/text:no separator:DOT number:/number:/g

s/text:i noLowerCase:true separator:DOT separator:SPACE/part:1 indication:/g
s/text:ii noLowerCase:true separator:DOT separator:SPACE/part:2 indication:/g
s/text:iii noLowerCase:true separator:DOT separator:SPACE/part:3 indication:/g
s/text:iv noLowerCase:true separator:DOT separator:SPACE/part:4 indication:/g
s/text:v noLowerCase:true separator:DOT separator:SPACE/part:5 indication:/g
s/text:vi noLowerCase:true separator:DOT separator:SPACE/part:6 indication:/g
s/text:vii noLowerCase:true separator:DOT separator:SPACE/part:7 indication:/g
s/text:viii noLowerCase:true separator:DOT separator:SPACE/part:8 indication:/g
s/text:ix noLowerCase:true separator:DOT separator:SPACE/part:9 indication:/g

s/lastWord:true//

s/text:in separator:SPACE text:\([abcdefg]\) noLowerCase:true text:major/tonality:\1 mode:major/g
s/text:in separator:SPACE text:\([abcdefg]\) noLowerCase:true text:minor/tonality:\1 mode:minor/g
s/text:in separator:SPACE text:\([abcdefg]\) noLowerCase:true separator:SPACE text:major/tonality:\1 mode:major/g
s/text:in separator:SPACE text:\([abcdefg]\) noLowerCase:true separator:SPACE text:minor/tonality:\1 mode:minor/g
s/text:in separator:SPACE text:\([abcdefg]\) noLowerCase:true separator:MINUS text:flat separator:SPACE text:major/tonality:\1 alteration:flat mode:major/g
s/text:in separator:SPACE text:\([abcdefg]\) noLowerCase:true separator:MINUS text:flat separator:SPACE text:minor/tonality:\1 alteration:flat mode:minor/g
s/text:in separator:SPACE text:\([abcdefg]\) noLowerCase:true separator:MINUS text:sharp separator:SPACE text:major/tonality:\1 alteration:sharp mode:major/g
s/text:in separator:SPACE text:\([abcdefg]\) noLowerCase:true separator:MINUS text:sharp separator:SPACE text:minor/tonality:\1 alteration:sharp mode:minor/g

s/text:\([abcdefg]\) noLowerCase:true separator:MINUS text:dur/tonality:\1 mode:major/g

s/separator:PIPE number:/title:/g


s/separator:SPACE/ /g
s/separator:COMMA/,/g
s/separator:TWO_POINTS/,/g
s/separator:GUILLEMET//g
s/separator:MINUS/- /g
s/separator:OPARENTHESE/ (/g
s/separator:CPARENTHESE/ )/g
s/separator:DOT /. )/g
s/separator:QUOTE/'/g
s/separator:ESPERLUETTE/\&/g
s/separator:QUESTION/?/g
s/separator:EXCLAMATION/!/g

s/month:[A-Z]* //g

s/noLowerCase:true //g

s/  / /g
s/^ //

s/ text://g

#s/artistName:\(.*\) track:/artistName:"\1" track:/g