# backup  DB using mysql default cli

wp db export ./DB/exported-wp-db.sql --add-drop-table --allow-root

wp search-replace 'wp-framework.pp.ua' 'wp-framework.local' --report-changed-only=true --precise --all-tables

wp search-replace 'wp-framework.local' 'wp-framework.pp.ua' --report-changed-only=true --precise --all-tables --export=DB/exported-search-replaced-wp-db.sql
