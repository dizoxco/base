<?php

use Illuminate\Database\Seeder;

abstract class CustomSeeder extends Seeder
{
    public function execute(string $key = null)
    {
        if (CONFIG !== null && array_key_exists($key, CONFIG)) {
            $this->createFromConfigFile(CONFIG[$key]);
        } else {
            $this->createAndSaveToConfigFile();
        }
    }

    protected function saveToFile(array $config): void
    {
        $config = array_merge(
            array_wrap(json_decode(file_get_contents(base_path('seeder.json')), true)),
            $config
        );

        file_put_contents(
            base_path('seeder.json'),
            json_encode($config, JSON_PRETTY_PRINT)
        );
    }

    protected function yesOrNo(string $quastion): bool
    {
        return $this->command->anticipate($quastion, ['y', 'n'], 'y') === 'y' ? true : false;
    }

    abstract protected function createFromConfigFile($config);

    abstract protected function createAndSaveToConfigFile();

    abstract protected function create($config);
}
