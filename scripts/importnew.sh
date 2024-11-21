#!/bin/bash
set -e
cd "$(dirname "$0")"/../src/newcontent/
rename -v 's/^.* \[(.*)\]\.(.*)$/$1.$2/' *
for i in *.jpg; do convert "$i" -- "${i%.jpg}.webp"; done
mv -uiv -- * ../content/
