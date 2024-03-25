#!/bin/sh
cd /app && \
echo '************* Install project dependencies *************' && \
/usr/local/bin/npm install && \
echo '************* Run gulp-watch *************' && \
/app/node_modules/.bin/gulp serve $1
