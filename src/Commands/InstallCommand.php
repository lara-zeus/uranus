<?php

namespace LaraZeus\Uranus\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Sleep;

use function Laravel\Prompts\info;
use function Laravel\Prompts\pause;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\select;

class InstallCommand extends Command
{
    use Loader;

    protected $signature = 'uranus:install';

    protected $description = 'install Uranus package';

    public function handle(): void
    {
        $admin = select(
            label: 'What admin panel are you using?',
            options: [
                'nova' => 'Laravel Nova',
                'voyager' => 'Laravel Voyager',
                'backpack' => 'Backpack for Laravel',
            ],
            hint: 'Choose the admin panel currently integrated into your application'
        );

        info('scanning files...');

        $models = self::collectClasses(
            app_path('Models'),
            'App\\Models\\'
        );

        progress(
            label: 'Converting your app...',
            steps: $models,
            callback: function ($model, $progress) use ($admin) {
                $modelName = str($model)->explode('\\')->last();

                $suf = match ($admin) {
                    'backpack' => 'CrudController.php',
                    default => '',
                };

                $progress
                    ->label('Reading ' . $modelName . $suf)
                    ->hint('Creating ' . $modelName . 'Resource');
                Sleep::for(rand(1, 2))->seconds();

                return true;
            },
            hint: 'This may take some time.',
        );

        info('Congratulations All Done!');

        $this->output->writeln('<bg=blue;fg=white> INFO </> Login Information:' . PHP_EOL);
        $this->output->writeln('<fg=gray>➜</> <fg=red>URL:</><options=bold>' . config('app.url') . '/admin</>');
        $this->output->writeln('<fg=gray>➜</> <fg=red>Email Address:</><options=bold>admin@' . parse_url(config('app.url'))['host'] . '</>');
        $this->output->writeln('<fg=gray>➜</> <fg=red>Password:</><options=bold>password</>');
        $this->output->writeln('');

        pause('Press ENTER to continue...');
        pause('BTW...');
        pause('if you didnt noticed...');

        $this->output->writeln('It’s prank day!');
        $this->output->writeln('L(° O °L)     APRIL FOOOOOOOLS     L(° O °L)');
        $this->output->writeln('consider ⭐️ the package in github 	✌(-‿-)✌');
    }
}
