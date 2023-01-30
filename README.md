# php-orm
work in progress php ORM

## what does it do and why?
i've created this as an personal exercise for both PHP and SQL.

it provides a simple interface to interact with, for example:
```php
$posts = Post::with('comments')->get();
```
i've created it with a very similair syntax to laravel.


### features and task list;
- [x] to Many relationship
- [x] belongsTo relationship
- [ ] to many through relationship
- [ ] inserting
- [ ] updating
- [ ] deleting
