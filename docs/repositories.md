# Repositories

This library provides several repositories to interact with different Jira API endpoints. Here are some of the available repositories:
- `AttachmentRepository`: Add, retrieve, download and remove issue attachments.
- `ComponentRepository`: Manage project components in Jira.
- `CustomFieldOptionRepository`: Manage custom field options in Jira.
- `IssueCommentRepository`: Manage comments on issues in Jira.
- `IssueLinkRepository`: Manage links between issues in Jira.
- `IssueRepository`: Manage issues in Jira.
- `IssueTransitionRepository`: List and execute workflow transitions on issues in Jira.
- `LinkTypeRepository`: List available issue link types in Jira.
- `ProjectRepository`: Manage projects in Jira.
- `UserRepository`: Look up and search Jira users.
- `VersionRepository`: Manage versions in Jira.
- `WorklogRepository`: Log and manage time spent on issues in Jira.

A repository is missing? You can suggest a new repository by opening an issue and/or pull request.

Several `findAll()` methods above return a paginated result envelope. See [Pagination](pagination.md) for how to iterate over every page with `Paginator`.
