# Manage messages in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/centrex/laravel-messages.svg?style=flat-square)](https://packagist.org/packages/centrex/laravel-messages)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/centrex/laravel-messages/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/centrex/laravel-messages/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/centrex/laravel-messages/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/centrex/laravel-messages/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/centrex/laravel-messages?style=flat-square)](https://packagist.org/packages/centrex/laravel-messages)

Thread-based polymorphic messaging for any Eloquent model. Supports multi-participant conversations, read/unread tracking, and soft-deletes on both threads and messages.

## Installation

```bash
composer require centrex/laravel-messages
php artisan vendor:publish --tag="laravel-messages-migrations"
php artisan migrate
```

## Usage

### 1. Add the trait to your model

```php
use Centrex\Messages\Concerns\HasMessages;

class User extends Authenticatable
{
    use HasMessages;
}
```

### 2. Create a thread and add messages

```php
use Centrex\Messages\Models\Thread;

// Create a new thread
$thread = Thread::create(['subject' => 'Order inquiry']);

// Add participants
$thread->addParticipant($user);
$thread->addParticipant($support);
// or multiple at once
$thread->addParticipants([$user, $support, $manager]);

// Post a message
$thread->addMessage(['body' => 'When will my order ship?'], $user);
```

### 3. Read threads and messages

```php
// All threads a user participates in
$user->threads;

// Threads with unread messages
Thread::forModelWithNewMessages($user)->get();

// All threads for a participant
Thread::forModel($user)->get();

// Latest message in a thread
$thread->getLatestMessage();

// All messages in a thread
$thread->messages;

// Who started the thread
$thread->creator();
```

### 4. Unread tracking

```php
// Mark thread as read by user
$thread->markAsRead($user);

// Check if thread has unread messages for user
$thread->isUnread($user);  // bool

// Count of threads with new messages
$user->newMessagesCount();

// IDs of threads with new messages
$user->threadsWithNewMessages();
```

### 5. Participant management

```php
$thread->hasParticipant($user);   // bool
$thread->activateAllParticipants(); // restore soft-deleted participants
```

## Testing

```bash
composer test        # full suite
composer test:unit   # pest only
composer test:types  # phpstan
composer lint        # pint
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [centrex](https://github.com/centrex)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
