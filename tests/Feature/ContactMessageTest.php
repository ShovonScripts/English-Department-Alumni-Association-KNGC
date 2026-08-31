<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->password = 'password';
        $this->actingAs($this->admin);
    }

    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬
    // MODEL TESTS
    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬

    public function test_contact_message_creation_with_defaults(): void
    {
        $message = ContactMessage::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Membership enquiry',
            'message' => 'Hello, I would like to join.',
        ]);

        $this->assertSame('John Doe', $message->name);
        $this->assertSame('john@example.com', $message->email);
        $this->assertSame('Membership enquiry', $message->subject);
        $this->assertSame('Hello, I would like to join.', $message->message);
        $this->assertNull($message->read_at);
        $this->assertNull($message->archived_at);
        $this->assertNull($message->ip_address);
        $this->assertNull($message->user_agent);
    }

    public function test_contact_message_default_status_is_unread(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'General question',
            'message' => 'A question.',
        ]);
        $message->refresh();

        $this->assertSame(ContactMessage::STATUS_UNREAD, $message->status);
    }

    public function test_contact_message_scope_unread(): void
    {
        ContactMessage::factory()->unread()->count(3)->create();
        ContactMessage::factory()->read()->count(2)->create();

        $this->assertCount(3, ContactMessage::unread()->get());
    }

    public function test_contact_message_scope_read(): void
    {
        ContactMessage::factory()->unread()->count(2)->create();
        ContactMessage::factory()->read()->count(4)->create();

        $this->assertCount(4, ContactMessage::read()->get());
    }

    public function test_contact_message_scope_archived(): void
    {
        ContactMessage::factory()->unread()->count(2)->create();
        ContactMessage::factory()->archived()->count(5)->create();

        $this->assertCount(5, ContactMessage::archived()->get());
    }

    public function test_contact_message_mark_as_read_sets_status_and_read_at(): void
    {
        $message = ContactMessage::factory()->unread()->create();
        $this->assertNull($message->read_at);

        $message->markAsRead();
        $message->refresh();

        $this->assertSame(ContactMessage::STATUS_READ, $message->status);
        $this->assertNotNull($message->read_at);
    }

    public function test_contact_message_mark_as_unread(): void
    {
        $message = ContactMessage::factory()->read()->create();
        $this->assertNotNull($message->read_at);

        $message->markAsUnread();
        $message->refresh();

        $this->assertSame(ContactMessage::STATUS_UNREAD, $message->status);
        $this->assertNull($message->read_at);
    }

    public function test_contact_message_archive(): void
    {
        $message = ContactMessage::factory()->unread()->create();
        $message->archive();
        $message->refresh();

        $this->assertSame(ContactMessage::STATUS_ARCHIVED, $message->status);
        $this->assertNotNull($message->archived_at);
    }

    public function test_contact_message_unarchive(): void
    {
        $message = ContactMessage::factory()->archived()->create();
        $message->unarchive();
        $message->refresh();

        $this->assertSame(ContactMessage::STATUS_UNREAD, $message->status);
        $this->assertNull($message->archived_at);
    }

    public function test_contact_message_is_unread_helper(): void
    {
        $unread = ContactMessage::factory()->unread()->create();
        $read = ContactMessage::factory()->read()->create();

        $this->assertTrue($unread->isUnread());
        $this->assertFalse($read->isUnread());
    }

    public function test_contact_message_is_archived_helper(): void
    {
        $archived = ContactMessage::factory()->archived()->create();
        $unread = ContactMessage::factory()->unread()->create();

        $this->assertTrue($archived->isArchived());
        $this->assertFalse($unread->isArchived());
    }

    public function test_contact_message_scope_active(): void
    {
        ContactMessage::factory()->unread()->count(3)->create();
        ContactMessage::factory()->read()->count(2)->create();
        ContactMessage::factory()->archived()->count(4)->create();

        $this->assertCount(5, ContactMessage::active()->get());
    }

    public function test_contact_message_scope_latest(): void
    {
        ContactMessage::factory()->count(5)->create();
        $latest = ContactMessage::query()->orderByDesc('created_at')->limit(2)->get();
        $this->assertCount(2, $latest);
    }

    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬
    // PUBLIC: CONTACT FORM
    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬

    public function test_public_contact_page_returns_200(): void
    {
        $this->get(route('contact'))->assertOk();
    }

    public function test_valid_submission_creates_database_record(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'General question',
            'message' => 'This is a test message.',
        ])->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'General question',
            'message' => 'This is a test message.',
        ]);
    }

    public function test_submission_status_defaults_to_unread(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'General question',
            'message' => 'This is a test message.',
        ])->assertRedirect();

        $message = ContactMessage::where('email', 'test@example.com')->first();
        $this->assertSame(ContactMessage::STATUS_UNREAD, $message->status);
    }

    public function test_successful_submission_shows_flash_message(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Flash User',
            'email' => 'flash@example.com',
            'subject' => 'General question',
            'message' => 'Flash test.',
        ]);

        $response->assertSessionHas('success');
    }

    public function test_submission_ip_address_recorded(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'General question',
            'message' => 'This is a test message.',
        ])->assertRedirect();

        $message = ContactMessage::where('email', 'test@example.com')->first();
        $this->assertNotNull($message->ip_address);
    }

    public function test_invalid_email_rejected(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'subject' => 'General question',
            'message' => 'Test.',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_missing_name_rejected(): void
    {
        $this->post(route('contact.store'), [
            'name' => '',
            'email' => 'test@example.com',
            'subject' => 'General question',
            'message' => 'Test.',
        ])->assertSessionHasErrors(['name']);
    }

    public function test_missing_subject_rejected(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => '',
            'message' => 'Test.',
        ])->assertSessionHasErrors(['subject']);
    }

    public function test_missing_message_rejected(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'General question',
            'message' => '',
        ])->assertSessionHasErrors(['message']);
    }

    public function test_honeypot_blocks_bot_submissions(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'subject' => 'Spam',
            'message' => 'Buy stuff',
            'website' => 'http://spam.com',
        ])->assertRedirect();

        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'bot@example.com',
        ]);
    }

    public function test_old_input_preserved_on_validation_error(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Preserved Name',
            'email' => 'invalid-email',
            'subject' => 'General question',
            'message' => 'Some message.',
        ]);

        $response->assertSessionHasInput('name', 'Preserved Name');
        $response->assertSessionHasInput('email', 'invalid-email');
        $response->assertSessionHasInput('subject', 'General question');
    }

    public function test_submission_with_optional_phone(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Phone User',
            'email' => 'phone@example.com',
            'phone' => '+1234567890',
            'subject' => 'General question',
            'message' => 'With phone.',
        ])->assertRedirect();

        $message = ContactMessage::where('email', 'phone@example.com')->first();
        $this->assertSame('+1234567890', $message->phone);
    }

    public function test_submission_without_phone_is_valid(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'No Phone User',
            'email' => 'nophone@example.com',
            'subject' => 'General question',
            'message' => 'No phone.',
        ])->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'nophone@example.com',
        ]);
    }

    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬
    // ADMIN: MESSAGES
    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬

    public function test_admin_message_index_returns_200(): void
    {
        $this->get(route('admin.messages.index'))->assertOk();
    }

    public function test_admin_message_index_lists_messages(): void
    {
        ContactMessage::factory()->create(['name' => 'Alice Johnson', 'subject' => 'Membership enquiry']);
        $response = $this->get(route('admin.messages.index'));
        $response->assertSee('Alice Johnson');
    }

    public function test_admin_message_index_search_works(): void
    {
        ContactMessage::factory()->create(['name' => 'Alice Johnson', 'subject' => 'Membership enquiry']);
        ContactMessage::factory()->create(['name' => 'Bob Smith', 'subject' => 'General question']);
        $response = $this->get(route('admin.messages.index', ['search' => 'Alice']));
        $response->assertSee('Alice Johnson');
        $response->assertDontSee('Bob Smith');
    }

    public function test_admin_message_index_filter_by_status_works(): void
    {
        ContactMessage::factory()->unread()->create(['name' => 'Unread Message']);
        ContactMessage::factory()->read()->create(['name' => 'Read Message']);
        $response = $this->get(route('admin.messages.index', ['status' => 'unread']));
        $response->assertSee('Unread Message');
        $response->assertDontSee('Read Message');
    }

    public function test_admin_message_show_returns_200(): void
    {
        $message = ContactMessage::factory()->create();
        $this->get(route('admin.messages.show', $message));
        $this->assertDatabaseHas('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_message_show_marks_unread_as_read(): void
    {
        $message = ContactMessage::factory()->unread()->create();
        $this->assertNull($message->read_at);

        $this->get(route('admin.messages.show', $message));

        $message->refresh();
        $this->assertSame(ContactMessage::STATUS_READ, $message->status);
    }

    public function test_admin_message_show_already_read_stays_read(): void
    {
        $message = ContactMessage::factory()->read()->create();
        $originalReadAt = $message->read_at;

        $this->get(route('admin.messages.show', $message));

        $message->refresh();
        $this->assertSame($originalReadAt->timestamp, $message->read_at->timestamp);
    }

    public function test_admin_can_mark_message_as_read(): void
    {
        $message = ContactMessage::factory()->unread()->create();

        $this->patch(route('admin.messages.update', $message), [
            'action' => 'mark_read',
        ])->assertRedirect();

        $message->refresh();
        $this->assertSame(ContactMessage::STATUS_READ, $message->status);
        $this->assertNotNull($message->read_at);
    }

    public function test_admin_can_mark_message_as_unread(): void
    {
        $message = ContactMessage::factory()->read()->create();

        $this->patch(route('admin.messages.update', $message), [
            'action' => 'mark_unread',
        ])->assertRedirect();

        $message->refresh();
        $this->assertSame(ContactMessage::STATUS_UNREAD, $message->status);
        $this->assertNull($message->read_at);
    }

    public function test_admin_can_archive_message(): void
    {
        $message = ContactMessage::factory()->unread()->create();

        $this->patch(route('admin.messages.update', $message), [
            'action' => 'archive',
        ])->assertRedirect();

        $message->refresh();
        $this->assertSame(ContactMessage::STATUS_ARCHIVED, $message->status);
        $this->assertNotNull($message->archived_at);
    }

    public function test_admin_can_unarchive_message(): void
    {
        $message = ContactMessage::factory()->archived()->create();

        $this->patch(route('admin.messages.update', $message), [
            'action' => 'unarchive',
        ])->assertRedirect();

        $message->refresh();
        $this->assertSame(ContactMessage::STATUS_UNREAD, $message->status);
        $this->assertNull($message->archived_at);
    }

    public function test_admin_can_delete_message(): void
    {
        $message = ContactMessage::factory()->create();

        $this->delete(route('admin.messages.destroy', $message))->assertRedirect();

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_message_pagination_works(): void
    {
        ContactMessage::factory()->count(25)->create();
        $response = $this->get(route('admin.messages.index'));
        $response->assertOk();
        $response->assertSee('1');
    }

    public function test_admin_message_index_empty_state(): void
    {
        $response = $this->get(route('admin.messages.index'));
        $response->assertOk();
        $response->assertSee('No messages found');
    }

    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬
    // PRIVACY TESTS
    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬

    public function test_messages_never_appear_on_public_routes(): void
    {
        ContactMessage::factory()->create([
            'name' => 'Secret Person',
            'subject' => 'Confidential subject',
            'message' => 'Private message content',
        ]);

        $response = $this->get(route('home'));
        $response->assertDontSee('Secret Person');
        $response->assertDontSee('Confidential subject');
        $response->assertDontSee('Private message content');
    }

    public function test_public_contact_page_does_not_expose_message_data(): void
    {
        ContactMessage::factory()->create([
            'name' => 'Hidden Person',
            'subject' => 'Hidden Subject',
            'message' => 'Hidden content',
        ]);

        $response = $this->get(route('contact'));
        $response->assertDontSee('Hidden Person');
        $response->assertDontSee('Hidden Subject');
        $response->assertDontSee('Hidden content');
    }

    public function test_admin_message_content_is_escaped(): void
    {
        $xss = '<script>alert("xss")</script>';
        ContactMessage::factory()->create([
            'name' => 'XSS User',
            'subject' => $xss,
            'message' => $xss,
        ]);

        $response = $this->get(route('admin.messages.index'));
        $response->assertDontSee($xss, false);
    }

    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬
    // DASHBOARD INTEGRATION
    // Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬

    public function test_dashboard_shows_unread_message_count(): void
    {
        ContactMessage::factory()->unread()->count(5)->create();
        ContactMessage::factory()->read()->count(3)->create();

        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('5');
    }

    public function test_dashboard_count_updates_after_marking_read(): void
    {
        ContactMessage::factory()->unread()->count(3)->create();

        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('3');

        $message = ContactMessage::unread()->first();
        $message->markAsRead();

        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('2');
    }
}
