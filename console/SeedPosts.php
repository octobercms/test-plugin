<?php namespace October\Test\Console;

use Faker\Factory;
use Illuminate\Console\Command;
use October\Test\Models\Post;

class SeedPosts extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'test:seed-posts';

    /**
     * @var string The console command description.
     */
    protected $description = 'Create many posts for tests list filters with many records';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $faker = Factory::create();

        $this->info('Seeding in progress, please wait (this can take few minutes)');

        for ($i = 0; $i < 5000; $i++) {
            $post = Post::create([
                'name'    => $faker->sentence(5, true),
                'content' => $faker->sentence(15, true)
            ]);

            for ($j = 0; $j < 4; $j++) {
                $post->comments()->create([
                    'name'    => $faker->userName,
                    'content' => $faker->sentence(15, true)
                ]);
            }
        }
    }

}
