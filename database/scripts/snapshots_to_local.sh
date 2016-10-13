#!/bin/bash

# Requires quick_sync wrapper for rsync from SPLIT Concepts

export CURRENT_DIR=$(dirname $0)

source $CURRENT_DIR/.config.staging

export PROD_BASE_DIR=$BASE_SYSTEM_DIR

source $CURRENT_DIR/.config.local

export LOCAL_BASE_DIR=../..

export SNAPSHOTS_PATH=/database/scripts/snapshots

quick_sync 24 jamesl@renewalert.com:$PROD_BASE_DIR$SNAPSHOTS_PATH/ $LOCAL_BASE_DIR$SNAPSHOTS_PATH

