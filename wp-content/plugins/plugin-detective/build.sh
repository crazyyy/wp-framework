#!/bin/bash
CURRENT_DIR=$(pwd)
PD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $PD_DIR/troubleshoot/app/
npm install
npm run build

cd $PD_DIR

rsync -avr --delete --exclude .DS_Store /Users/nathan/Sites/wporg-svn-mirror/plugin-detective/ /tmp/plugin-detective/
svn co http://plugins.svn.wordpress.org/plugin-detective/ /tmp/plugin-detective
rsync -avr --delete --exclude .DS_Store /tmp/plugin-detective/ /Users/nathan/Sites/wporg-svn-mirror/plugin-detective/

cd $CURRENT_DIR