<?php
declare(strict_types=1);
namespace Casa\CasaTimeline\Controller;

use Casa\CasaTimeline\Domain\Repository\TagRepository;
use Casa\CasaTimeline\Domain\Repository\EventRepository;
use Casa\CasaTimeline\Controller\EventController;

use \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Fluid\View\StandaloneView;
use \TYPO3\CMS\Extbase\Object\ObjectManager;
use \TYPO3\CMS\Fluid\View\TemplateView;

use \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use DateTime;
use \In2code\Femanager\Domain\Model\User;
use \In2code\Femanager\Domain\Repository\UserRepository;

use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\Transient;

/***
 *
 * This file is part of the "Slackinventory" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Carlos Sampaio Peredo <carlos-sampaio-peredo@hotmail.com>, Webcasa
 *
 ***/
/**
 * MaterialController
 */
class AjaxController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

  /** @var ResponseFactoryInterface */
  protected $responseFactory;

  /**
    * @var \Casa\CasaTimeline\Domain\Repository\EventRepository
  */
  protected ?EventRepository $eventRepository = null;

  public function injectEventRepository(EventRepository $eventRepository): void 
  {    $this->eventRepository = $eventRepository;  }

  /**
   * tagRepository
   * 
   * @var \Casa\CasaTimeline\Domain\Repository\TagRepository
   */
  protected ?TagRepository $tagRepository = null;

  public function injectTagRepository(TagRepository $tagRepository): void 
  {    $this->tagRepository = $tagRepository;  }

//   /**
//   * @var \In2code\Femanager\Domain\Repository\UserRepository
//   * @TYPO3\CMS\Extbase\Annotation\Inject
//   */
//   protected ?$feUserRepository = null;

//  /**
//    * frontendUserRepository
//    *
//    * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
//    * @TYPO3\CMS\Extbase\Annotation\Inject
//    */
//  protected ?$userGroupRepository = null;


  //  /**
  //  * @param EventRepository $eventRepository
  //  */


  //    /**
  //  * @param TagRepository $tagRepository
  //  */



    /**
     * action more
     *
     *
     * @return void
     */
     public function galleryAction(): ResponseInterface
     {

      // \TYPO3\CMS\Core\Utility\DebugUtility::debug($_REQUEST);
      $event = $this->eventRepository->findByUid($_REQUEST['uid']);
      $totalImages = count($event->getImages());
      
      $this->view->assignMultiple(['event' => $event, 'totalImgs' => $totalImages]);
      
      trim($this->view->render());

      return $this->htmlResponse();
    }

    /**
     * action more
     *
     *
     * @return void
     */
     public function timelineAction(): ResponseInterface {
       $dateTill = NULL;
       $dateFrom = NULL;
       $eventsAll = $this->eventRepository->findAll($date);
       $yearSelected = $_REQUEST['data'][1];
       $dateSelected = $yearSelected.'-01-01';
       $searchword = '';
       $isAdmin = false;
       $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
      
       if ($user == 1) {
          $isAdmin = true;
       }

       /* ADMIN Steuerung*/ 
      //  $user = $this->feUserRepository->findByUid($userId);
      //  if (isset($user)) {
      //    $groups = $user->getUsergroup();
      //    foreach ($groups as $key => $group) {
      //       if ($group->getTitle() == 'admin') {
      //          $isAdmin = true;
      //       }
      //    }
      //  }

       $checkboxesCount = count($_REQUEST['data']); // -3 Anzahl andere Optionen davor
       if ($_REQUEST['data'][2] != '') {
          $searchword = $_REQUEST['data'][2];
       }


       $tags = [];
       for ($i=3; $i <= $checkboxesCount ; $i++) {
           $tagName = $_REQUEST['data'][$i];
           if ($tagName !== 'unchecked') {
            
               $tagsResult = $this->tagRepository->findByName($tagName);
               if (count($tagsResult) > 0) {
                  array_push($tags, $tagsResult[0]->getUid());
               }
           }
       }

       if ($yearSelected != 'Alle') {
         $dateTill = date_create_from_format('Y-m-d', date('Y-m-d', strtotime($dateSelected.' + 1 year')));
         $dateFrom = date_create_from_format('Y-m-d', date('Y-m-d', strtotime($dateSelected.' - 1 day')));
       }else {
         if (count($tags) > 1) {
           $this->addFlashMessage('Bei "Alle" maximal 1 Tag zulässig', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
           $tags = [$tags[0]];
         }else if(count($tags) < 1){
           $dateTill = date_create_from_format('Y-m-d', date('Y-m-d', strtotime(date('Y').'-01-01 + 1 year')));
           $dateFrom = date_create_from_format('Y-m-d', date('Y-m-d', strtotime(date('Y').'-01-01')));
           $this->addFlashMessage('Bei "Alle" mindestens 1 Tag erforderlich', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
           $tags = [$tags[0]];
         }

       }

      $events = $this->eventRepository->findByDate($dateFrom, $dateTill, $isAdmin, $tags, $searchword);

      $this->view->assignMultiple(['events' => $events]);

      trim($this->view->render());

      return $this->htmlResponse();
    }



}
