#!/bin/bash
#requires imagemagick
convert $1 -resize "240x160^" -gravity center -crop 240x160+0+0 +repage thumb.$1
convert $1 -resize "1024x683^" -gravity center -crop 1024x683+0+0 +repage $1
