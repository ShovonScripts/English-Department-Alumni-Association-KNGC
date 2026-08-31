<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlumniTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->password = 'password';
        $this->actingAs($this->admin);
    }

    public function test_public_directory_lists_active_alumni_only(): void
    {
        $active = Alumni::factory()->create(['status' => Alumni::STATUS_ACTIVE]);
        $inactive = Alumni::factory()->inactive()->create();

        $response = $this->get(route('alumni.index'));

        $response->assertOk();
        $response->assertSee($active->full_name);
        $response->assertDontSee($inactive->full_name);
    }

    public function test_public_directory_supports_search_and_filters(): void
    {
        $match = Alumni::factory()->create([
            'full_name' => 'Adeola Searchable',
            'country' => 'Nigeria',
            'batch' => '2010',
            'status' => Alumni::STATUS_ACTIVE,
            'is_featured' => false,
        ]);
        $other = Alumni::factory()->create([
            'full_name' => 'Bola Quiet',
            'country' => 'Kenya',
            'batch' => '2005',
            'status' => Alumni::STATUS_ACTIVE,
            'is_featured' => false,
        ]);

        $this->get(route('alumni.index', ['search' => 'Searchable']))
            ->assertSee('Adeola Searchable')
            ->assertDontSee('Bola Quiet');
        $this->get(route('alumni.index', ['country' => 'Nigeria']))
            ->assertSee('Adeola Searchable')
            ->assertDontSee('Bola Quiet');
        $this->get(route('alumni.index', ['batch' => '2010']))
            ->assertSee('Adeola Searchable')
            ->assertDontSee('Bola Quiet');
    }

    public function test_public_profile_shows_public_info_but_not_contact_details(): void
    {
        $alumnus = Alumni::factory()->create([
            'full_name' => 'Test Person',
            'designation' => 'Lecturer',
            'email' => 'secret@example.com',
            'phone' => '+15555550100',
            'status' => Alumni::STATUS_ACTIVE,
        ]);

        $response = $this->get(route('alumni.show', $alumnus));

        $response->assertOk();
        $response->assertSee('Test Person');
        $response->assertSee('Lecturer');
        $response->assertDontSee('secret@example.com');
        $response->assertDontSee('+15555550100');
    }

    public function test_inactive_alumni_profile_is_not_public(): void
    {
        $alumnus = Alumni::factory()->inactive()->create();

        $this->get(route('alumni.show', $alumnus))->assertNotFound();
    }

    public function test_homepage_shows_featured_alumni_only(): void
    {
        $featured = Alumni::factory()->featured()->create(['full_name' => 'Featured Face']);
        Alumni::factory()->create(['full_name' => 'Not Featured', 'is_featured' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Featured Face')
            ->assertDontSee('Not Featured');
    }

    public function test_admin_can_create_alumni_record(): void
    {
        $this->post(route('admin.alumni.store'), [
            'full_name' => 'John Doe',
            'batch' => '2010',
            'graduation_year' => '2014',
            'status' => 'active',
        ])->assertRedirect(route('admin.alumni.index'));

        $this->assertDatabaseHas('alumni', ['full_name' => 'John Doe', 'slug' => 'john-doe']);
    }

    public function test_admin_generates_unique_slugs(): void
    {
        Alumni::factory()->create(['full_name' => 'John Doe', 'slug' => 'john-doe']);

        $this->post(route('admin.alumni.store'), [
            'full_name' => 'John Doe',
            'status' => 'active',
        ])->assertRedirect(route('admin.alumni.index'));

        $this->assertDatabaseHas('alumni', ['full_name' => 'John Doe', 'slug' => 'john-doe-2']);
    }

    public function test_admin_requires_a_name(): void
    {
        $this->post(route('admin.alumni.store'), [
            'full_name' => '',
            'status' => 'active',
        ])->assertSessionHasErrors('full_name');
    }

    public function test_admin_can_update_alumni_record(): void
    {
        $alumnus = Alumni::factory()->create(['full_name' => 'Old Name']);

        $this->put(route('admin.alumni.update', $alumnus), [
            'full_name' => 'New Name',
            'status' => 'active',
        ])->assertRedirect(route('admin.alumni.index'));

        $this->assertDatabaseHas('alumni', ['full_name' => 'New Name']);
    }

    public function test_admin_can_delete_alumni_record(): void
    {
        $alumnus = Alumni::factory()->create();

        $this->delete(route('admin.alumni.destroy', $alumnus))
            ->assertRedirect(route('admin.alumni.index'));

        $this->assertDatabaseMissing('alumni', ['id' => $alumnus->id]);
    }

    public function test_admin_index_lists_and_filters_alumni(): void
    {
        $alumnus = Alumni::factory()->create(['full_name' => 'Filterable Name']);

        $this->get(route('admin.alumni.index'))
            ->assertOk()
            ->assertSee('Filterable Name');
        $this->get(route('admin.alumni.index', ['search' => 'Filterable']))
            ->assertOk()
            ->assertSee($alumnus->full_name);
    }

    public function test_admin_dashboard_shows_active_alumni_count(): void
    {
        Alumni::factory()->count(3)->create(['status' => Alumni::STATUS_ACTIVE]);
        Alumni::factory()->count(2)->inactive()->create();

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('3');
    }

    public function test_profile_photo_is_uploaded_and_stored(): void
    {
        Storage::fake('public');

        $this->post(route('admin.alumni.store'), [
            'full_name' => 'Photo Person',
            'status' => 'active',
            'profile_photo' => UploadedFile::fake()->image('portrait.jpg', 200, 200),
        ])->assertRedirect(route('admin.alumni.index'));

        $alumnus = Alumni::where('full_name', 'Photo Person')->firstOrFail();

        $this->assertNotNull($alumnus->profile_photo);
        Storage::disk('public')->assertExists($alumnus->profile_photo);
    }

    public function test_public_directory_shows_empty_state_when_no_results(): void
    {
        Alumni::factory()->create(['full_name' => 'Only Person', 'status' => Alumni::STATUS_ACTIVE]);

        $this->get(route('alumni.index', ['search' => 'NoSuchPersonXYZ']))
            ->assertOk()
            ->assertSee('No alumni match');
    }
}
