# Waccounts - World of Warcraft Accounts Manager

Dedicated interface to manage World of Warcraft accounts by NoxInmortus.

- Release 2.0 : 23/05/2020
- Initial Release 1.0 : 10/07/18

-----
[Title ToDo]: #todo
[Title Features]: #features
[Title Requirements and Installation]: #requirements-and-installation
[Title Protected Files]: #protected-files
[Title Customization]: #customization
[Title Troubleshooting]: #troubleshooting
[Title Sources]: #sources
[Title License]: #license
[Title Demo]: #demo

## Summary
- [ToDo][Title Todo]
- [Features][Title Features]
- [Requirements and Installation][Title Requirements and Installation]
- [Protected Files][Title Protected Files]
- [Customization][Title Customization]
- [Troubleshooting][Title Troubleshooting]
- [Sources][Title Sources]
- [License][Title License]
- [Demo][Title Demo]

## ToDo
- CI tests
- PHP lint
- PHP 7.3 compatibility
- Remove boostrap dependency
- Minors adds/changes :
  - assign `gmlevel` to a variable
  - assign customization stuff to variable(s)
  - Optimize CSS/img

## Features
- Every user existing in `realmd.account` can connect to this interface.
- Simple players can only update their own password.
- Administrators (gmlevel 3), can update other accounts password, create new accounts and delete accounts.
- Administrator have also access to a account list menu where is displayed usernames, gmlevel and failed_logins attempts.
- A register option can be actived in order to allow unregistered users to create their own account.

You can also read logs in the log folder, actions (passwords update, new account) are logged with time and user.
Notice there is also a `robots.txt` file in order to help not being indexed by google robots or others.

So before use it, you should at least have an administrator account created with the console or through SQL in realmd database.

Console :
```
account create [$accountName] [$accountPassword]
account set gmlevel [$accountId|$accountName] 3
```

SQL :
```
INSERT INTO account (username,sha_pass_hash) VALUES ('username', UPPER(SHA1(CONCAT(UPPER('[$accountName]'),':',UPPER('[$accountPassword]')))));
UPDATE account SET gmlevel = 3 WHERE username = [$accountName];
```

Notice that [$accountName] & [$accountPassword] are variables used for examples, dont add the brackets ([,]) or the dollar ($).

## Requirements and Installation
```
- Web server
- MySQL server, user and database
- PHP 7 and php7.0-msql

- Put files in `/var/www/waccounts`
- Setup docroot rights : `chown -R www-data: /var/www/Waccounts`
- Edit `include/config.php` for your database details
- apache2 example vhost :

<VirtualHost *:80>
        ServerName wow.yourdomain.com

        ServerAdmin webmaster@yourdomain.com
        DocumentRoot /var/www/waccounts

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        <Directory /var/www/Waccounts>
                AllowOverride ALL
        </Directory>
</VirtualHost>
```

## Protected Files
- `config.php` (htaccess)
- log folder (htaccess)

## Customization
If you want to customise the site to your details, here are the files you may wants to edit :
- `include/footer.php`
- `include/header.php`
- `index.php`

The gmlevel requirement for administrators can be edited in the `index.php`.

## Troubleshooting
- Check for requirements.
- Check for logs in log folder.
- Check if bootstrap url does not need to be updated (`footer.php` and `header.php`).

## Sources
- https://www.getmangos.eu/wiki/referenceinfo/otherfiles/managing-user-accounts-using-3rd-party-apps-r20088/
- https://mangoszero-docs.readthedocs.io/en/latest/database/realm/account.html
- https://trinitycore.atlassian.net/wiki/spaces/tc/pages/2130004/account
- https://trinitycore.atlassian.net/wiki/spaces/tc/pages/2129969/characters+table#characters(table)-class
- https://github.com/cmangos/issues/wiki/Characters#class

htaccess sources :
- https://stackoverflow.com/questions/5046100/prevent-access-to-files-in-a-certain-folder
- https://stackoverflow.com/questions/11728976/how-to-deny-access-to-a-file-in-htaccess

## License
MIT

## Demo
Login Page
![Demo1](/demo/demo1.png)
Player Page
![Demo2](/demo/demo2.png)
Administrator Page
![Demo3](/demo/demo3.png)
Account list Page
![Demo4](/demo/demo4.png)
