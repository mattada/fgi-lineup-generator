#!/bin/bash

source $(dirname $0)/.config.env

BACKUP_DIR="$CURRENT_DIR/snapshots"
BACKUP_DATE="$(date +'%Y%m%d')"
BACKUP_FILE=$BACKUP_DIR"/db_snapshot_"$BACKUP_DATE".sql"

mysqldump -h $DB_HOST -u $DB_USER --password="$DB_PASSWORD" --no-create-db --disable-keys --add-drop-table --routines "$DB_NAME" | sed -r -e 's/DEFINER=`[^`]+`@`[^`]+`/ /' > "$BACKUP_FILE"

chmod 640 "$BACKUP_FILE"

echo "Database dump file created at: $BACKUP_FILE"