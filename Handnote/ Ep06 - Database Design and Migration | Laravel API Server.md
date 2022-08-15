            ##  Ep06 - Database Design and Migration | Laravel API Server
                Entity Relationship Diagram (ERD)
                        draw.io
                        Database Engine:
                                sequal Pro
                                https://alvarotrigo.com/blog/mac-database-software/
                        php artisan
                        php artisan make:model --help
                        php artisan make:model Post -a
                        php artisan make:model Post -a --api
                        php artisan make:model Comment -a --api
                        php artisan make:migration create_post_user_table --create=post_user
                Migration is a cconcept of version control for database;
                Laravel will run mmigration files in chronological order, ie by following the
                 timestamp in the migration file name .
                The artisan console is a wondeerful tool to generate boilerplate for our project
