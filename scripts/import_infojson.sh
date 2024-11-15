#!/bin/bash

set -e

PSQL='psql -h localhost ytarchive www-media'

jq -c 'with_entries(select([.key] | inside([
	"id", "title", "thumbnail", "description", "channel_id", "channel_url", "duration",
	"view_count", "webpage_url", "comment_count", "like_count", "channel",
	"channel_follower_count", "uploader", "uploader_id", "uploader_url", "upload_date",
	"timestamp", "fulltitle", "fps", "aspect_ratio", "ext", "tags"])))
	| .tags |= join(" ")' -- "$@" \
		| $PSQL -c "COPY temp (data) FROM STDIN (FORMAT csv, QUOTE e'\x01', DELIMITER e'\x02');"

$PSQL -c 'INSERT INTO video SELECT p.* FROM temp t CROSS JOIN jsonb_populate_record(null::video, t.data) AS p;'

$PSQL -c 'TRUNCATE TABLE temp;'
