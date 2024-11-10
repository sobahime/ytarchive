CREATE TABLE temp (data jsonb);

CREATE TABLE video (
	id			TEXT PRIMARY KEY,
	title			TEXT,
	-- thumbnails table
	thumbnail		TEXT,
	description		TEXT,
	channel_id		TEXT,
	channel_url		TEXT,
	duration		INT,
	view_count		INT,
	webpage_url		TEXT,
	-- tags table
	-- subtitles table
	comment_count		INT,
	like_count		INT,
	channel			TEXT,
	channel_follower_count	INT,
	uploader		TEXT,
	uploader_id		TEXT,
	uploader_url		TEXT,
	upload_date		TEXT,
	timestamp		INT,
	fulltitle		TEXT,
	fps			INT,
	aspect_ratio		FLOAT
);
