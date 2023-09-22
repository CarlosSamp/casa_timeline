<?php
namespace Casa\CasaTimeline\Tests\Unit\Controller;

/**
 * Test case.
 */
class TagControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    // /**
    //  * @var \Casa\CasaTimeline\Controller\TagController
    //  */
    // protected $subject = null;
    //
    // protected function setUp()
    // {
    //     parent::setUp();
    //     $this->subject = $this->getMockBuilder(\Casa\CasaTimeline\Controller\TagController::class)
    //         ->setMethods(['redirect', 'forward', 'addFlashMessage'])
    //         ->disableOriginalConstructor()
    //         ->getMock();
    // }
    //
    // protected function tearDown()
    // {
    //     parent::tearDown();
    // }
    //
    // /**
    //  * @test
    //  */
    // public function listActionFetchesAllTagsFromRepositoryAndAssignsThemToView()
    // {
    //
    //     $allTags = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
    //         ->disableOriginalConstructor()
    //         ->getMock();
    //
    //     $tagRepository = $this->getMockBuilder(\::class)
    //         ->setMethods(['findAll'])
    //         ->disableOriginalConstructor()
    //         ->getMock();
    //     $tagRepository->expects(self::once())->method('findAll')->will(self::returnValue($allTags));
    //     $this->inject($this->subject, 'tagRepository', $tagRepository);
    //
    //     $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
    //     $view->expects(self::once())->method('assign')->with('tags', $allTags);
    //     $this->inject($this->subject, 'view', $view);
    //
    //     $this->subject->listAction();
    // }
    //
    // /**
    //  * @test
    //  */
    // public function createActionAddsTheGivenTagToTagRepository()
    // {
    //     $tag = new \Casa\CasaTimeline\Domain\Model\Tag();
    //
    //     $tagRepository = $this->getMockBuilder(\::class)
    //         ->setMethods(['add'])
    //         ->disableOriginalConstructor()
    //         ->getMock();
    //
    //     $tagRepository->expects(self::once())->method('add')->with($tag);
    //     $this->inject($this->subject, 'tagRepository', $tagRepository);
    //
    //     $this->subject->createAction($tag);
    // }
    //
    // /**
    //  * @test
    //  */
    // public function deleteActionRemovesTheGivenTagFromTagRepository()
    // {
    //     $tag = new \Casa\CasaTimeline\Domain\Model\Tag();
    //
    //     $tagRepository = $this->getMockBuilder(\::class)
    //         ->setMethods(['remove'])
    //         ->disableOriginalConstructor()
    //         ->getMock();
    //
    //     $tagRepository->expects(self::once())->method('remove')->with($tag);
    //     $this->inject($this->subject, 'tagRepository', $tagRepository);
    //
    //     $this->subject->deleteAction($tag);
    // }
}
