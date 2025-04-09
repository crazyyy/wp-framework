ssh ${{ secrets.DEPLOY_USER }}@${{ secrets.DEPLOY_HOST }} << 'EOF'
  export DEPLOY_PATH=${{ secrets.DEPLOY_PATH }}
  export BACKUP_DIR=~/releases
  export LOG_FILE=~/deploy.log
  export TIMESTAMP=$(date +'%Y%m%d-%H%M%S')
  mkdir -p $BACKUP_DIR

  if [ -d "$DEPLOY_PATH" ]; then
    cp -a $DEPLOY_PATH $BACKUP_DIR/backup-$TIMESTAMP
    echo "$BACKUP_DIR/backup-$TIMESTAMP" > $BACKUP_DIR/latest
  fi

  echo "$(date '+%F %T') | Backup created: backup-$TIMESTAMP" >> $LOG_FILE

  # Rotate backups (keep only 5 latest)
  ls -dt $BACKUP_DIR/backup-* | tail -n +6 | xargs -r rm -rf
EOF
