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
```
the syntax is very inspired by laravel


### features and task list;
- [x] to Many relationship
- [x] belongsTo relationship
- [ ] to many through relationship
- [x] inserting
- [ ] updating
- [ ] deleting
- [ ] Easy database config 
- [ ] query building
