#!/bin/sh


# MySQL user
user=root
# MySQL password
password=admin

SCRIPT_PATH=`readlink -f "$0"`
SCRIPT_DIR=`dirname "$SCRIPT_PATH"`

# Backup storage directory 
backupfolder="${SCRIPT_DIR}/database/Backups"

echo $backupfolder;
sqlfile=$backupfolder/all-database-$(date +%d-%m-%Y_%H-%M-%S).sql
# Create a backup 
sudo mysqldump -u $user -p$password events > $sqlfile 