<?php

use App\Models\Taxonomy;


class TagTableSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('taxonomies');
    }

    protected function createFromConfigFile($taxonomies): void
    {
        foreach ($taxonomies as $taxonomy) {
            foreach ($taxonomy['tags'] as $tag) {
                $tags[] = ['label' => $tag['label'], 'slug' => $tag['slug']];
            }
            Taxonomy::create([
                'group_name' => $taxonomy['group_name'],
                'slug' => $taxonomy['slug'],
                'label' => $taxonomy['label']
            ])->tags()->createMany($tags);
            $tags = [];
        }
    }

    protected function createAndSaveToConfigFile(): void
    {
        $config_taxonomies = [];
        $want_taxonomies = true;
        while ($want_taxonomies) {
            $taxonomi_group_name = $this->command->ask('Enter the Taxonomi group name');
            $taxonomi_slug = $this->command->ask('Enter the Taxonomi slug');
            $taxonomi_label = $this->command->ask('Enter the Taxonomi label');

            $taxonomie_tag_members = [];
            $want_more_member = true;
            while ($want_more_member) {
                $tag_label = $this->command->ask('Enter a tag label for ' . $taxonomi_group_name);
                $tag_slug = $this->command->ask('Enter a tag slug for ' . $taxonomi_group_name);
                $taxonomie_tag_members[] = [
                    'label' => $tag_label,
                    'slug' => $tag_slug,
                ];
                $want_more_member = $this->command->anticipate('Do you want more tags?', ['y', 'n'], 'y') === 'y' ? true : false;
            }

            Taxonomy::create([
                'group_name' => $taxonomi_group_name,
                'slug' => $taxonomi_slug,
                'label' => $taxonomi_label,
            ])->tags()->createMany($taxonomie_tag_members);

            $config_taxonomies['taxonomies'][] = [
                'group_name' => $taxonomi_group_name,
                'slug' => $taxonomi_slug,
                'label' => $taxonomi_label,
                'tags' => $taxonomie_tag_members
            ];
            $want_taxonomies = $this->command->anticipate('Do you want more taxonomies?', ['y', 'n'], 'y') === 'y' ? true : false;
        }

        $this->saveToFile($config_taxonomies);
    }

    protected function create($config)
    {
        // TODO: Implement create() method.
    }
}
