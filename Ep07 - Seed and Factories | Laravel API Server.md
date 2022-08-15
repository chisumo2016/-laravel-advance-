            ### Ep07 - Seed and Factories | Laravel API Server

                php artisan make:seeder UserSeedeer 
                        php artisan db:seed
                        php artisan migrate:fresh --seed   
                 
                Goes in the Seeder class of each class
                      Disable Check of FK
                 DB::statement('SET FOREIGN_KEY_CHECKS= 0');
                 DB::table('users')->truncate();
                ---------CODE-----

                  Unable Check of FK
                 DB::statement('SET FOREIGN_KEY_CHECKS= 1');

           Create a folder Called Traits -> seeders Folder -> Class ->TruncateTable.php
           Call the truncateTable Trait inside the UserSeeder.php
                use TruncateTable;
                
          Create a folder Called Traits -> seeders Folder -> Class -> DisableForeignKeys.php
          Call the DisableForeignKeys Trait inside the UserSeeder.php
                use DisableForeignKeys;
         
         Override our title
                Post::factory(3)->create();
                Post::factory(3)->state(['title' => 'untitled'])->create();
                
                 php artisan db:seed    

        Or we can create this state in PostFactory class
                 public  function  untitled()
                    {
                        return $this->state(['title' => 'untitled']);
                    }
          use it inside the PostSeeder,call the untitled method
                Post::factory(3)->state(['title' => 'untitled'])->create();
                Post::factory(3)->untitled()->create();

        Seeding is referred to populating the datbase with dummy data
        Factory classes are used to generate fake models
        We put the main seeding logic in the classed called Seeder
        We can use the db:seed Artisann command to trigger the seeders.
