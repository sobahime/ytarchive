CREATE TABLE temp (data jsonb);

CREATE TABLE video (
    id                      TEXT PRIMARY KEY,
    title                   TEXT,
    -- thumbnails table
    thumbnail               TEXT,
    description             TEXT,
    channel_id              TEXT,
    channel_url             TEXT,
    duration                INT,
    view_count              INT,
    webpage_url             TEXT,
    tags                    TEXT,
    -- subtitles table
    comment_count           INT,
    like_count              INT,
    channel                 TEXT,
    channel_follower_count  INT,
    uploader                TEXT,
    uploader_id             TEXT,
    uploader_url            TEXT,
    upload_date             TEXT,
    timestamp               INT,
    fulltitle               TEXT,
    fps                     INT,
    aspect_ratio            FLOAT,
    ext                     TEXT
);

CREATE TABLE comment (
    id                      TEXT PRIMARY KEY,
    parent                  TEXT,
    text                    TEXT,
    like_count              INT,
    author_id               TEXT,
    author                  TEXT,
    author_thumbnail        TEXT,
    author_is_uploader      BOOLEAN,
    author_is_verified      BOOLEAN,
    author_url              TEXT,
    is_favorited            BOOLEAN,
    _time_text              TEXT,
    timestamp               INT,
    is_pinned               BOOLEAN,
    video_id                TEXT,
    FOREIGN KEY (parent) REFERENCES comment(id),
    FOREIGN KEY (video_id) REFERENCES video(id)
);
