# agents.md

## Agent Guidance — laravel-messages

### Package Purpose
Polymorphic messaging system for Laravel. Any model can send and receive messages via the `HasMessages` concern. Messages are stored in a single table with polymorphic sender/recipient.

### Before Making Changes
- Read `src/Models/` to understand the `Message` model fields and relations
- Read `src/Concerns/` to understand the `HasMessages` trait API exposed to host models
- Check `src/Facades/` to understand the top-level API
- Review migrations before touching message fields

### Common Tasks

**Adding a message status (e.g., read/unread)**
1. Add a migration with a `read_at` timestamp column (nullable)
2. Add a `markAsRead()` method to the `Message` model
3. Add a `unread()` scope for filtering
4. Expose via the `HasMessages` trait if callers need it on the owner model

**Adding thread/conversation support**
1. Add a `thread_id` column via migration (nullable for backwards compatibility)
2. Add a `Thread` model if grouping is needed
3. Update the `HasMessages` trait to include thread-scoped query methods
4. Do not break existing code that fetches messages without threads

**Adding attachments**
- Do not store binary data in the messages table
- Store a file path or reference to a storage disk
- Add a separate `message_attachments` migration

### Testing
```sh
composer test:unit        # pest
composer test:types       # phpstan
composer test:lint        # pint
```

Test that polymorphic sender/recipient work for different model types:
```php
$user->sendMessage($admin, 'Hello');
expect($admin->receivedMessages()->count())->toBe(1);
```

### Safe Operations
- Adding new methods to the `HasMessages` trait
- Adding nullable columns to messages table
- Adding model scopes
- Adding tests

### Risky Operations — Confirm Before Doing
- Renaming polymorphic columns (`messageable_type`, `messageable_id`, `sender_type`, `sender_id`)
- Changing the trait method signatures (breaks host app code)
- Removing soft-delete support if present

### Do Not
- Store raw file contents in the messages table
- Eager-load all messages without pagination — can be unbounded
- Skip `declare(strict_types=1)` in any new file
