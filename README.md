# php-orm

work in progress php ORM

## what does it do?

i've created this as an personal exercise for both PHP and SQL.

it provides a simple interface to interact with, for example:

```php
$posts = Post::with('comments')->get();
$post = Post::create([
  "title" => "my first post!",
  "content" => "This is my first post!"
]);

Post::hydrate($post);
$post->comments()->attach([
  "content" => "This is a comment",
]);
```

the syntax is very inspired by laravel

### features and task list;

- [x] to Many relationship
- [x] belongsTo relationship
- [x] inserting
- [x] inserting trough relationship
- [ ] updating // now working on
- [ ] deleting
- [ ] Easy database config
- [ ] query building
- [ ] to many through relationship
