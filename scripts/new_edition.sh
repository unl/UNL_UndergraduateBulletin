#!/bin/bash

EDITION=$((`ls data | sort -rn | head -1`))
NEW_EDITION=$((${EDITION} + 1))
EDITIONS_FILE=src/Edition/Editions.php

SED_EXPR='/$editions = \[/ a\'$'\n''\        '$NEW_EDITION,$'\n'

cp -rp data/$EDITION data/$NEW_EDITION
sed -e "$SED_EXPR" -i "" "$EDITIONS_FILE"
git add data/$NEW_EDITION $EDITIONS_FILE
git commit -m "Create $NEW_EDITION edition from $EDITION"
