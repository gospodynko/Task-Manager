# blog

#initial project
0. composer install
1. phinx.yml.example > phinx.yml
2. Configure phinx.yml
    
    2.1 adapter: mysql\
    2.2 name: db_name ... etc
    
3. app/config.ini.example > app/config.ini
4. Configure mysql connection
5. Start migrations <code>vendor/bin/phinx migrate -e production</code>
6. Start php server <code>php -S 127.0.0.1:8001</code>
7. Or add into Apache hosts and create config

#enjoy
