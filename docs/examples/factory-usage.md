# 🧰 Factory Usage

The examples here are intended for local tests or Tinker sessions. Never run the sample seeders against production.

## Create a user
```php
$user = App\Models\User::factory()->create();
```

The current UserFactory:
- Generates synthetic names, usernames and email addresses.
- Marks generated email as verified.
- Uses a shared development password value of password123.
- Generates a profile image URL through Faker.

Treat the shared factory password as test-only. Do not seed public/staging/production users with it.

## Create a post for a known user
```php
$user = App\Models\User::factory()->create();

$post = App\Models\Post::factory()->create([
    'user_id' => $user->id,
    'visibility' => 'draft',
]);
```

The current PostFactory selects a random existing user by default. Create a user first or explicitly provide user_id. The factory content and image fields are synthetic; the image value may be a Faker-generated URL rather than a locally uploaded file path.

## Seeders
The DatabaseSeeder calls UserSeeder and PostSeeder. UserSeeder creates 30 users; PostSeeder creates 50 posts. The UserFactory shares a predictable development password. Use only with a disposable local database.

## Safety
- Never seed production.
- Never copy production data into tests.
- Check the active database connection before seeding.
- Avoid publishing Tinker output containing personal data.
