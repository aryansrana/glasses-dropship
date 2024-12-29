#!/bin/bash

if [ ! -e tagsoup-1.2.1.jar ];then
    wget https://repo1.maven.org/maven2/org/ccil/cowan/tagsoup/tagsoup/1.2.1/tagsoup-1.2.1.jar
fi

check=`egrep -c '.*zennioptical.*' $1`

if [ $check -gt 0 ];then
    first=$1
    second=$2
else
    first=$2
    second=$1
fi

while true;do  
    chmod 600 "$first"
    chmod 600 "$second"
    chmod 700 "parser.py"

    counter=1
    for line in `cat $first`;do
        touch $counter.html
        chmod 600 $counter.html
        wget -O $counter.html $line
        java -jar tagsoup-1.2.1.jar --output-encoding=utf-8 --files $counter.html
        chmod 600 $counter.xhtml
        python3 parser.py $counter.xhtml
        rm $counter.html
        rm $counter.xhtml
        counter=`expr $counter + 1`
    done

    for line in `cat $second`;do
        touch $counter.html
        chmod 600 $counter.html
        wget -O $counter.html $line
        java -jar tagsoup-1.2.1.jar --output-encoding=utf-8 --files $counter.html
        chmod 600 $counter.xhtml
        python3 parser.py $counter.xhtml
        rm $counter.html
        rm $counter.xhtml
        counter=`expr $counter + 1`
    done
    sleep 6h
done
