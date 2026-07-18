# Contributing to Jira API Client

Thank you for considering contributing to this project! Your help is greatly appreciated. Please follow these guidelines to ensure a smooth contribution process.

## Prerequisites
- PHP 8.2 or higher
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

## Release process (maintainers)
Releases follow [Semantic Versioning](https://semver.org/) and are cut from tags with no `v` prefix (`0.3.0`, not `v0.3.0`), matching the existing tag history.

1. Move the relevant entries from the `[Unreleased]` section of [CHANGELOG.md](CHANGELOG.md) into a new `## [X.Y.Z] - YYYY-MM-DD` section, and update the comparison links at the bottom of the file.
2. Merge that change, then tag the resulting commit and push the tag: `git tag X.Y.Z && git push origin X.Y.Z`.
3. Pushing the tag triggers `.github/workflows/release.yml`, which runs the test suite and creates a GitHub Release, using the matching `CHANGELOG.md` section as its body (falling back to GitHub's auto-generated notes if no section matches the tag).
4. [Packagist](https://packagist.org/packages/xen3r0/jira-api-client) picks up the new tag automatically via its GitHub webhook — no separate publish step is needed. If a fresh clone of the package is ever set up on Packagist, make sure "GitHub Hook" is enabled under the package's Settings tab so this stays automatic.

## Need Help?
If you have questions, feel free to open an issue or contact the maintainers.

Thank you for contributing!

