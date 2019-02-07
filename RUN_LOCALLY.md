1. Set up WordPress dev environment - in my case, MAMP
1. Clone repo - https://pantheon.io/docs/local-development/
1. Copy live database - https://pantheon.io/docs/local-development/
  gunzip < betabase.sql.gz | /Applications/MAMP/Library/bin/mysql -uroot -p avlbeta
  (in my env, the myqsl part is aliased to mampsql to avoid confusion with the other mysql installed with homebrew)
1. Overwrite local database connected to repo with live database - https://pantheon.io/docs/local-development/
1. Replace URLs: https://looks-awesome.com/copying-live-wordpress-site-localhost
1. Get media files via sftp - https://pantheon.io/docs/local-development/
1. Change permissions of uploads directory - `chmod -R 755 uploads`
