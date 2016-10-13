#!/bin/bash

source $(dirname $0)/.config.env

if (test "$3" != ""); then
    BACKUP_DATE=$3
else
    echo "Invalid Backup Date: Add backup date YYYYMMDD as first argument after environment"
    exit
fi

BACKUP_DIR="$CURRENT_DIR/snapshots"
BACKUP_FILE=$BACKUP_DIR"/db_snapshot_"$BACKUP_DATE".sql"

mysql -h $DB_HOST -u $DB_USER --password="$DB_PASSWORD" --database="$DB_NAME" < "$BACKUP_FILE"