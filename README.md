# Task manager api

#initial project
0. composer install
1. phinx.yml.example > phinx.yml
2. Configure phinx.yml
    
    2.1 adapter: mysql\
    2.2 name: db_name ... etc
    
3. app/config.ini.example > app/config.ini
4. Configure mysql connection
5. Start migrations <code>vendor/bin/phinx migrate -e production</code>
5. Start seed <code>vendor/bin/phinx seed:run</code>
6. Install php intl https://stackoverflow.com/questions/42243461/how-to-install-php-intl-extension-in-ubuntu-14-04
7. Admin login:test@gmail.com passw:admin
6. Start php server <code>php -S 127.0.0.1:8001</code>
7. Or add into Apache hosts and create config

Routes in index.php

#enjoy
