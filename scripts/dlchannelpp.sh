#!/bin/bash
cd "$(dirname "$0")"/../src/content/
for i in $(jq -r '.channel_url | if . == null then  empty else . end' -- *.info.json | sort -u)
do yt-dlp --skip-download --write-thumbnail --max-downloads 1 --download-archive archivechannelpp.txt -o "thumbnail:" --cookies /home/debian/cookies.txt $i
done
