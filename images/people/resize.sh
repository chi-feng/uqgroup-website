#!/bin/bash
#requires imagemagick
convert $1 -resize "150x200^" -gravity center -crop 150x200+0+0 +repage $2