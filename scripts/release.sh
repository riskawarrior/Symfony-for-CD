#!/usr/bin/env bash

# Enter project root
cd ..

# Deploy as...
SU="sudo -EHu www-data"

$SU phing prod-update-prepare
# Backup database before ruining it
$SU mysqldump -u root symfony | gzip | $SU tee var/backup/backup_$(git rev-parse HEAD).sql.gz >/dev/null
$SU phing prod-update
$SU phing prod-update-warmup
