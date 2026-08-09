# Known Issues — laravel-messages

_Last checked: 2026-08-02_

## Failing tests

No failing tests. `composer test:unit` (`pest -p`) runs 2 tests, 4 assertions, both pass. Note the test suite is very thin relative to the feature surface exposed by `src/Models/Thread.php` and `Participant.php` (thread creation, read/unread tracking, participant matching) — none of that behavior is exercised by `tests/ExampleTest.php`/`ArchTest.php`.

`composer test` itself halts early: `test:refacto` (rector `--dry-run`) exits non-zero before `test:lint`/`test:types`/`test:unit` get a chance to run in the chained script, so each step was run individually to get a full picture (see below).

## Style / static-analysis debt

- `vendor/bin/pint --test` — passes clean (`{"result":"pass"}`).
- `vendor/bin/rector --dry-run` — **3 files** flagged, all the same single rule (`AddOverrideAttributeToOverriddenMethodsRector`, i.e. missing `#[\Override]` on overridden methods): `src/Facades/Messages.php`, `src/MessagesServiceProvider.php`, `tests/TestCase.php`. Run `composer refacto` to apply.
- `vendor/bin/phpstan analyse` — **43 errors**, all unbaselined (`phpstan-baseline.neon` is empty, so none of this is pre-accepted debt). The bulk are in `src/Models/Thread.php` and `Message.php`:
  - Missing generic type params on relation return types (`BelongsTo`, `MorphTo`, `HasMany`) throughout `Message.php`, `Participant.php`, `Thread.php`.
  - Several **undefined-property** accesses that look like real bugs, not just missing PHPDoc: `Thread.php:118` and `:132` access `Participant::$last_read` (no such column/cast declared on the model), `Thread.php:132` accesses `Thread::$updated_at` (phpstan can't see it declared), and `Message.php:38-39` access `$participant_id`/`$participant_type` on `Message` (these look like they belong on `Participant`, not `Message`).
  - Several `Builder::where('participant_id', ...)` / `where('participant_type', ...)` calls (`Thread.php:145-146,160-161`) where phpstan says those aren't real properties on `Participant` — worth checking column names in the migration vs. what the model code assumes.
  - Missing param/return type hints on multiple `Thread` methods (`isUnread`, `hasParticipant`, `markAsRead`, `scopeForModel`, `scopeForModelWithNewMessages`, `addMessage`, `addMessages`, `addParticipants`, `getParticipantFromModel`, `participantsIdsAndTypes`).
  - `Thread::getLatestMessage()` declared to return `Message` but can return `Message|null`.
  - 3 migration files: anonymous migration `up()` methods have no return type.

## TODO / FIXME markers

None found (`grep -rn "TODO\|FIXME" --include="*.php" src/ config/ database/`).

## Open GitHub issues

Not checked — the `gh` CLI is not installed in this environment.
