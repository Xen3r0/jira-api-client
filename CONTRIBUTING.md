# Contributing to Jira API Client

Thank you for considering contributing to this project! Your help is greatly appreciated. Please follow these guidelines to ensure a smooth contribution process.

## Prerequisites
- PHP 8.1 or higher
- Composer
- Git

## Getting Started
1. Fork the repository and clone your fork locally.
2. Install dependencies:
   ```bash
   composer install
   ```
3. Run tests to verify your environment:
   ```bash
   ./vendor/bin/phpunit
   ```

## Code Style
- Follow PSR-12 coding standards.
- Use type hints and PHPDoc where appropriate.
- Run PHPStan for static analysis:
  ```bash
  ./vendor/bin/phpstan analyse
  ```
- Format code with PHP-CS-Fixer:
  ```bash
  ./vendor/bin/php-cs-fixer fix
  ```

## Making Changes
- Create a new branch for your feature or bugfix.
- Write clear, descriptive commit messages.
- Add or update tests for your changes.
- Ensure all tests pass before submitting your pull request.

## Pull Requests
- Describe your changes and the motivation behind them.
- Reference related issues if applicable.
- Make sure your branch is up to date with the main branch.
- Squash commits if necessary.

## Reporting Issues
- Search for existing issues before opening a new one.
- Provide as much detail as possible (steps to reproduce, expected behavior, logs, etc.).

## Need Help?
If you have questions, feel free to open an issue or contact the maintainers.

Thank you for contributing!

