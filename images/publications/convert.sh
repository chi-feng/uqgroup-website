#!/bin/sh

for i in *.gif; do
    convert $i ${i%%.*}.png
done

for i in *.jpg; do
    convert $i ${i%%.*}.png
done

rm -vf *.gif
rm -vf *.jpg