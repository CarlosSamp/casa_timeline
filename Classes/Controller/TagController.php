<?php
namespace Casa\CasaTimeline\Controller;
use Casa\CasaTimeline\Domain\Repository\TagRepository;
use Casa\CasaTimeline\Domain\Repository\EventRepository;

/***
 *
 * This file is part of the "Timeline" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021
 *
 ***/
/**
 * TagController
 */
class TagController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
      /**
   * tagRepository
   * 
   * @var \Casa\CasaTimeline\Domain\Repository\TagRepository
   */
  protected ?TagRepository $tagRepository = null;

  public function injectTagRepository(TagRepository $tagRepository): void 
  {    $this->tagRepository = $tagRepository;  }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $tags = $this->tagRepository->findAll();
        $this->view->assign('tags', $tags);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * action create
     *
     * @param \Casa\CasaTimeline\Domain\Model\Tag $newTag
     * @return void
     */
    public function createAction(\Casa\CasaTimeline\Domain\Model\Tag $newTag)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
        $this->tagRepository->add($newTag);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \Casa\CasaTimeline\Domain\Model\Tag $tag
     * @return void
     */
    public function deleteAction(\Casa\CasaTimeline\Domain\Model\Tag $tag)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
        $this->tagRepository->remove($tag);
        $this->redirect('list');
    }
}
