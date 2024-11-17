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

jq -c '.id as $video_id | .comments[] | with_entries(select([.key] | inside([
	"id", "parent", "text", "like_count", "author_id", "author", "author_thumbnail",
	"author_is_uploader", "author_is_verified", "author_url", "is_favorited",
	"_time_text", "timestamp", "is_pinned"]))) | .video_id = $video_id | if .parent == "root" then .parent = null else . end' -- "$@" \
		| $PSQL -c "COPY temp (data) FROM STDIN (FORMAT csv, QUOTE e'\x01', DELIMITER e'\x02');"

$PSQL -c 'INSERT INTO comment SELECT p.* FROM temp t CROSS JOIN jsonb_populate_record(null::comment, t.data) AS p;'

$PSQL -c 'TRUNCATE TABLE temp;'
