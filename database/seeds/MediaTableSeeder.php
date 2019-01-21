<?php

class MediaTableSeeder extends CustomSeeder
{
    public function run()
    {
        Storage::deleteDirectory('public/media');
        Storage::makeDirectory('tmp',0777);
        parent::execute('media');
        Storage::deleteDirectory('tmp');
    }

    protected function createFromConfigFile($media)
    {
        $this->create($media);
    }

    protected function createAndSaveToConfigFile()
    {
        $want_more_media = true;
        while ($want_more_media) {
            $model = $this->command->ask('Do you want media for which model?');
            $available_categories = [
                'abstract', 'animals', 'business', 'cats', 'city', 'food', 'nightlife',
                'fashion', 'people', 'nature', 'sports', 'technics', 'transport'
            ];
            $category = $this->command->anticipate('Do you want which category belongs to this model?', $available_categories);
            $amount = (int) $this->command->ask('Do you want how many media for '.$model.'?');
            $config_media['media'][] = [
                'model' => $model,
                'amount'=> $amount,
                'category'=> $category,
            ];
            $want_more_media = $this->yesOrNo('more media?');
        }

        $this->create($config_media['media']);

        $this->saveToFile($config_media);
    }

    protected function create($media)
    {
        foreach ($media as $medium) {
            $model = "App\\Models\\".ucfirst($medium['model']);
            $collection = $model::take($medium['amount'])->inRandomOrder()->get();

            if (!method_exists($collection->first(),'addMediaFromUrl')) {
                continue;
            }

            $faker = Faker\Factory::create('fa_IR');
            foreach ($collection as $model) {
                $image = $faker->image(storage_path('app/tmp'),400,300, $medium['category'], false);
                $model->addMediaFromUrl(storage_path("app/tmp/$image"))->toMediaCollection('default');
            }
        }
    }
}
