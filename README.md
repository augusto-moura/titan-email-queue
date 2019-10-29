# About

**Titan E-mail Queue** is a Wordpress Plugin that allows you to add e-mails to a queue. Once a minute, the plugin will process 5 e-mails from that queue.

# How to use

Add e-mail messages to the queue using the function `titan_eq_add_email()` and that's it. Every minute, the plugin will process the next 5 e-mails. 

The `titan_eq_add_email()` function accepts as parameter an array with the following keys: `email_to`, `title`, `body`, `type` (optional), `info` (optional)

Example:
```php
titan_eq_add_email([
	'email_to' => 'the_email@email.com',
	'title' => 'The title of my e-mail',
	'body' => 
		'<p>The body of my message.</p>
		<p>It allows simple HTML too!</p>',
]);
```

* Repo: https://github.com/augusto-moura40/titan-email-queue
* Wordpress plugin page: ---