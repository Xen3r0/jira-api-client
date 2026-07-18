<?php

namespace Xen3r0\JiraApiClient\Tests\Model\Issue;

use PHPUnit\Framework\TestCase;
use Xen3r0\Adf\Node\Block\Document;
use Xen3r0\JiraApiClient\Model\Issue\CustomField;
use Xen3r0\JiraApiClient\Model\Issue\Fields;
use Xen3r0\JiraApiClient\Model\Issue\Issue;
use Xen3r0\JiraApiClient\Model\Issue\Link;
use Xen3r0\JiraApiClient\Model\Issue\Priority;
use Xen3r0\JiraApiClient\Model\Issue\Progress;
use Xen3r0\JiraApiClient\Model\Issue\Resolution;
use Xen3r0\JiraApiClient\Model\Issue\Type;
use Xen3r0\JiraApiClient\Model\Issue\Votes;
use Xen3r0\JiraApiClient\Model\Issue\Watches;
use Xen3r0\JiraApiClient\Model\Project\Component;
use Xen3r0\JiraApiClient\Model\Project\Project;
use Xen3r0\JiraApiClient\Model\Status\Status;
use Xen3r0\JiraApiClient\Model\User\User;
use Xen3r0\JiraApiClient\Model\Version\Version;
use Xen3r0\JiraApiClient\Model\Workflow\StatusCategory;

class FieldsTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $parent = (new Issue())->setKey('TEST-1');
        $version = (new Version())->setName('1.0.0');
        $statusCategoryChangeDate = new \DateTimeImmutable('2025-08-18T10:00:00+00:00');
        $statusCategory = (new StatusCategory())->setName('In Progress');
        $resolution = (new Resolution())->setName('Fixed');
        $priority = (new Priority())->setName('High');
        $link = (new Link())->setId('10000');
        $assignee = (new User())->setDisplayName('John Doe');
        $status = (new Status())->setName('In Progress');
        $component = (new Component())->setName('Component 1');
        $creator = (new User())->setDisplayName('Jane Doe');
        $subtask = (new Issue())->setKey('TEST-2');
        $reporter = (new User())->setDisplayName('John Smith');
        $aggregateProgress = (new Progress())->setProgress(1)->setTotal(2);
        $progress = (new Progress())->setProgress(3)->setTotal(4);
        $votes = (new Votes())->setVotes(5);
        $issueType = (new Type())->setName('Bug');
        $project = (new Project())->setKey('TEST');
        $resolutionDate = new \DateTimeImmutable('2025-08-19T10:00:00+00:00');
        $watches = (new Watches())->setWatchCount(2);
        $created = new \DateTimeImmutable('2025-08-17T10:00:00+00:00');
        $updated = new \DateTimeImmutable('2025-08-20T10:00:00+00:00');
        $description = new Document();
        $dueDate = new \DateTimeImmutable('2025-09-01');
        $customField = (new CustomField())->setId('customfield_10000')->setValue('foo');

        $fields = (new Fields())
            ->setSummary('This is a bug')
            ->setParent($parent)
            ->setFixVersions([$version])
            ->setStatusCategoryChangeDate($statusCategoryChangeDate)
            ->setStatusCategory($statusCategory)
            ->setResolution($resolution)
            ->setPriority($priority)
            ->setLabels(['bug', 'urgent'])
            ->setAggregateTimeOriginalEstimate(3600)
            ->setTimeEstimate(1800)
            ->setVersions([$version])
            ->setIssuelinks([$link])
            ->setAssignee($assignee)
            ->setStatus($status)
            ->setComponents([$component])
            ->setAggregateTimeEstimate(1800)
            ->setCreator($creator)
            ->setSubtasks([$subtask])
            ->setReporter($reporter)
            ->setAggregateProgress($aggregateProgress)
            ->setProgress($progress)
            ->setVotes($votes)
            ->setIssueType($issueType)
            ->setTimeSpent(900)
            ->setProject($project)
            ->setAggregateTimeSpent(900)
            ->setResolutionDate($resolutionDate)
            ->setWorkRatio(50)
            ->setWatches($watches)
            ->setCreated($created)
            ->setUpdated($updated)
            ->setTimeOriginalEstimate(3600)
            ->setDescription($description)
            ->setDueDate($dueDate)
            ->setCustomFields(['customfield_10000' => $customField]);

        $this->assertEquals('This is a bug', $fields->getSummary());
        $this->assertSame($parent, $fields->getParent());
        $this->assertSame([$version], $fields->getFixVersions());
        $this->assertEquals($statusCategoryChangeDate, $fields->getStatusCategoryChangeDate());
        $this->assertSame($statusCategory, $fields->getStatusCategory());
        $this->assertSame($resolution, $fields->getResolution());
        $this->assertSame($priority, $fields->getPriority());
        $this->assertEquals(['bug', 'urgent'], $fields->getLabels());
        $this->assertEquals(3600, $fields->getAggregateTimeOriginalEstimate());
        $this->assertEquals(1800, $fields->getTimeEstimate());
        $this->assertSame([$version], $fields->getVersions());
        $this->assertSame([$link], $fields->getIssuelinks());
        $this->assertSame($assignee, $fields->getAssignee());
        $this->assertSame($status, $fields->getStatus());
        $this->assertSame([$component], $fields->getComponents());
        $this->assertEquals(1800, $fields->getAggregateTimeEstimate());
        $this->assertSame($creator, $fields->getCreator());
        $this->assertSame([$subtask], $fields->getSubtasks());
        $this->assertSame($reporter, $fields->getReporter());
        $this->assertSame($aggregateProgress, $fields->getAggregateProgress());
        $this->assertSame($progress, $fields->getProgress());
        $this->assertSame($votes, $fields->getVotes());
        $this->assertSame($issueType, $fields->getIssueType());
        $this->assertEquals(900, $fields->getTimeSpent());
        $this->assertSame($project, $fields->getProject());
        $this->assertEquals(900, $fields->getAggregateTimeSpent());
        $this->assertEquals($resolutionDate, $fields->getResolutionDate());
        $this->assertEquals(50, $fields->getWorkRatio());
        $this->assertSame($watches, $fields->getWatches());
        $this->assertEquals($created, $fields->getCreated());
        $this->assertEquals($updated, $fields->getUpdated());
        $this->assertEquals(3600, $fields->getTimeOriginalEstimate());
        $this->assertSame($description, $fields->getDescription());
        $this->assertEquals($dueDate, $fields->getDueDate());
        $this->assertEquals(['customfield_10000' => $customField], $fields->getCustomFields());
    }

    public function testSetCustomFieldAddsToExistingList(): void
    {
        $customField = (new CustomField())->setId('customfield_10001')->setValue('bar');

        $fields = (new Fields())->setCustomField('customfield_10001', $customField);

        $this->assertSame(['customfield_10001' => $customField], $fields->getCustomFields());
    }
}
