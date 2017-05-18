#! /bin/bash


#mkdir bkup

for i in ../raw/*; do
    #echo "working on file $i\n"
    filename=$(echo $i | cut -f 3 -d '.')
    #echo "filename after first cut = $filename \n"
    basename=$(echo $filename | cut -f 3 -d '/')
    #echo "file basename = $basename \n"
    
    sed -i.orig 's/&/&amp;/g' $i
    sed -i.origsans.newline ':a;N;$!ba;s/\r\n/\n<lb\/>/g' $i
    sed -i.origsans.newline ':a;N;$!ba;s/\-\n<lb\/>/\-\n<lb break="no"\/>/g' $i
    
    cat teiTop.txt >> $basename.xml
    cat $i >> $basename.xml
    cat teiBottom.txt >> $basename.xml

done