1. Set up WordPress dev environment - in my case, MAMP
1. Clone repo - https://pantheon.io/docs/local-development/
1. Copy live database - https://pantheon.io/docs/local-development/
    then ctrl+click on url shown in terminal to download
    gunzip < betabase.sql.gz | /Applications/MAMP/Library/bin/mysql -uroot -p avlbeta
    (in my env, the myqsl part is aliased to mampsql to avoid confusion with the other mysql installed with homebrew)
1. Overwrite local database connected to repo with live database - https://pantheon.io/docs/local-development/
1. Replace URLs: https://looks-awesome.com/copying-live-wordpress-site-localhost
    UPDATE wp_posts SET guid = REPLACE (guid, 'https://beta.ashevillenc.gov', 'http://localhost')
    UPDATE wp_postmeta SET meta_value = replace(meta_value,'https://beta.ashevillenc.gov','http://localhost')
    UPDATE wp_posts SET post_content = replace(post_content, 'https://beta.ashevillenc.gov', 'http://localhost')
    UPDATE wp_options SET option_value = replace(option_value, 'https://beta.ashevillenc.gov', 'http://localhost') WHERE option_name = 'home' OR option_name = 'siteurl'
1. Get media files via sftp? - https://pantheon.io/docs/local-development/
1. Change permissions of uploads directory - `chmod -R 755 uploads`
