#!/bin/bash
PSQL='psql -h localhost ytarchive trollmaster'
for i in "$(dirname "$0")"/../src/content/*.info.json;
do if wget -O /dev/null -q "https://i.ytimg.com/vi/$(basename "${i%.info.json}")/hqdefault.jpg"
#then echo $i oui;
then $PSQL -c "UPDATE video SET isonline = TRUE WHERE id = '$(basename "${i%.info.json}")' "
else $PSQL -c "UPDATE video SET isonline = FALSE WHERE id = '$(basename "${i%.info.json}")' "
fi
done
