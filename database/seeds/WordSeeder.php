<?php

use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int)$this->command->ask('How many words do you need ?', 10);

        $this->command->info("Creating {$count} words.");

        factory(App\Word::class, $count)->create();

        $this->command->info($count.' words have been added!');
    }
}
