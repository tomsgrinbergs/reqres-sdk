## Usage

```php
$reqres = new ReqresClient('YOUR-API-KEY');

// Get a user by ID
$reqres->users->get(1);

// Get 2nd page of all users
$reqres->users->all(page: 2);

// Create a new user
$reqres->users->create(new CreateUser(
    name: 'John Doe',
    job: 'Software Engineer',
));
```


See `example.php` for usage example.

You can run the script by passing a valid API key via an env variable:
```bash
REQRES_API_KEY=YOUR-API-KEY php example.php
```

## Tests

Project includes both unit and feature tests. Feature tests are not run by default and require a valid API key.

To run unit tests use:
```bash
composer test
```

To run feature tests pass the API key via an env variable:
```bash
REQRES_API_KEY=YOUR-API-KEY composer test:feature
```

## Code Quality

Project includes the following code quality helpers:
```bash
# Auto-fix code style for PSR-12
composer fix

# Run static analysis using PHPStan
composer types

# Check code syle, run static analysis and run feature tests
composer test:all
```

