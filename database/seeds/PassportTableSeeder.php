<?php

class PassportTableSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('passport');
    }

    protected function createFromConfigFile($install)
    {
        $this->create($install);
    }

    protected function createAndSaveToConfigFile()
    {
        $install = $this->yesOrNo('Install passport?');

        $this->create($install);

        $this->saveToFile(['passport' => $install]);
    }

    protected function create($install)
    {
        if ($install) {
            $this->command->call('passport:install', ['--force' => true]);
        }
    }
}
