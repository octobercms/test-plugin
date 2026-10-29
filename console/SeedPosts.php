<?php namespace October\Test\Console;

use Db;
use Illuminate\Console\Command;
use October\Test\Models\Post;

/**
 * SeedPosts creates many posts with comments to test lists and filters with large record sets.
 *
 * @link https://docs.octobercms.com/4.x/extend/console-commands.html
 */
class SeedPosts extends Command
{
    /**
     * @var string signature for the console command.
     */
    protected $signature = 'test:seed-posts {--count=5000 : The number of posts to create}';

    /**
     * @var string description is the console command description
     */
    protected $description = 'Create many posts with comments to test lists with many records';

    /**
     * @var array words used to generate placeholder text.
     */
    protected $words = [
        'alpha', 'amber', 'anchor', 'apple', 'arch', 'atlas', 'autumn', 'beacon', 'birch', 'bloom',
        'bridge', 'canyon', 'cedar', 'cinder', 'cloud', 'comet', 'coral', 'crystal', 'delta', 'dune',
        'echo', 'ember', 'falcon', 'fern', 'field', 'forest', 'garden', 'glacier', 'harbor', 'hollow',
        'island', 'jade', 'lantern', 'meadow', 'mesa', 'mist', 'nova', 'orbit', 'pebble', 'prairie',
        'quartz', 'river', 'saddle', 'shadow', 'summit', 'thistle', 'timber', 'valley', 'willow', 'zephyr',
    ];

    /**
     * handle executes the console command.
     */
    public function handle()
    {
        $count = max(1, (int) $this->option('count'));

        $this->info("Creating {$count} posts with 4 comments each.");

        $bar = $this->output->createProgressBar($count);

        foreach (array_chunk(range(1, $count), 500) as $chunk) {
            Db::transaction(function () use ($chunk, $bar) {
                foreach ($chunk as $index) {
                    $this->createPost();
                    $bar->advance();
                }
            });
        }

        $bar->finish();
        $this->newLine();
    }

    /**
     * createPost saves a post with four comments.
     */
    protected function createPost()
    {
        $post = Post::create([
            'name' => $this->makeSentence(5),
            'content' => $this->makeSentence(15),
        ]);

        for ($i = 0; $i < 4; $i++) {
            $post->comments()->create([
                'name' => $this->makeUsername(),
                'content' => $this->makeSentence(15),
            ]);
        }
    }

    /**
     * makeSentence returns a capitalized sentence of random words.
     */
    protected function makeSentence(int $wordCount): string
    {
        $words = [];

        for ($i = 0; $i < $wordCount; $i++) {
            $words[] = $this->words[array_rand($this->words)];
        }

        return ucfirst(implode(' ', $words)) . '.';
    }

    /**
     * makeUsername returns a random username, such as willow42.
     */
    protected function makeUsername(): string
    {
        return $this->words[array_rand($this->words)] . random_int(1, 999);
    }
}
