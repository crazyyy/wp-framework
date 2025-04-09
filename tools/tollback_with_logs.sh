ssh ${{ secrets.DEPLOY_USER }}@${{ secrets.DEPLOY_HOST }} << 'EOF'
  export DEPLOY_PATH=${{ secrets.DEPLOY_PATH }}
  export BACKUP_DIR=~/releases
  export LOG_FILE=~/deploy.log

  if [ -f "$BACKUP_DIR/latest" ]; then
    LAST_BACKUP=$(cat $BACKUP_DIR/latest)
    if [ -d "$LAST_BACKUP" ]; then
      rm -rf $DEPLOY_PATH
      cp -a $LAST_BACKUP $DEPLOY_PATH
      echo "$(date '+%F %T') | Rollback executed from: $LAST_BACKUP" >> $LOG_FILE
    fi
  fi
EOF
