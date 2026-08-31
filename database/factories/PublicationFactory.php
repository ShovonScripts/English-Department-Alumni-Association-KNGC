<?php

namespace Database\Factories;

use App\Models\Publication;
use App\Models\PublicationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PublicationFactory extends Factory
{
    protected $model = Publication::class;

    public function definition(): array
    {
        $title = fake()->randomElement([
            'Postcolonial Narratives and the African Identity',
            'The Role of Literature in National Development',
            'Gender Discourse in Contemporary African Fiction',
            'Oral Tradition and Modern Storytelling',
            'The Influence of Chinua Achebe on Modern African Writing',
            'Language and Power in Postcolonial Literature',
            'Environmental Themes in African Poetry',
            'Digital Humanities and African Literary Studies',
            'Feminist Readings of Nigerian Novels',
            'The Politics of Translation in African Literature',
            'War and Memory in African Fiction',
            'Migration and Identity in the African Diaspora',
            'Censorship and Creative Freedom in Africa',
            'The Future of African Literary Criticism',
            'Eco-Criticism and African Environmental Writing',
            'Performance and Text in African Drama',
            'The African Novel in the Twenty-First Century',
            'Literary Activism and Social Change',
            'Rethinking the African Canon',
            'Children\'s Literature and Cultural Preservation in Africa',
        ]);

        return [
            'publication_category_id' => PublicationCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'subtitle' => fake()->optional()->sentence(),
            'description' => fake()->paragraph(),
            'cover_image' => null,
            'document_path' => null,
            'document_original_name' => null,
            'document_size' => null,
            'document_mime_type' => null,
            'author' => fake()->optional()->name(),
            'publisher' => fake()->optional()->company(),
            'publication_date' => fake()->dateTimeBetween('-5 years', 'now'),
            'status' => Publication::STATUS_DRAFT,
            'is_featured' => false,
            'sort_order' => 0,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => Publication::STATUS_PUBLISHED,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => Publication::STATUS_DRAFT,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn () => [
            'is_featured' => true,
        ]);
    }
}
