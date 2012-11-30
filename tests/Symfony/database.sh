php app/console doctrine:generate:entity --entity="MagicSSOBundle:User" --fields="un:string(255) pw:string(255) email:string(255)"

# if manually create entity class, use this command to complete the get and set
# methods.
php app/console doctrine:generate:entities MagicSSO

# use this command to update table schema in database
php app/console doctrine:schema:update --force

# doc reference
# http://symfony.com/doc/current/book/doctrine.html
