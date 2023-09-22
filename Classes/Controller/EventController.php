<?php
namespace Casa\CasaTimeline\Controller;

use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\Transient;
use Casa\CasaTimeline\PageTitle;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Casa\CasaTimeline\Domain\Repository\EventRepository;
use \In2code\Femanager\Domain\Repository\UserRepository;
use \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository;
use Casa\CasaTimeline\Controller\EventController;


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
 * EventController
 */
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
      * 
      * @var \Casa\CasaTimeline\Domain\Repository\EventRepository
      * @Lazy
    */
    protected ?EventRepository $eventRepository = null;

    // /**
    //   * 
    //   * @var \In2code\Femanager\Domain\Repository\UserRepository
    //   *
    // */
    // protected ?UserRepository $feUserRepository = null;

    // /**
    //  * frontendUserRepository
    //  * 
    //  * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
    //  * 
    //  */
    // protected ?FrontendUserGroupRepository $userGroupRepository = null;
    
  /**
   * @param EventRepository $eventRepository
   */
  public function injectEventRepository(
    EventRepository $eventRepository, 
    
    ): void 
  {
    $this->eventRepository = $eventRepository;
    
    $this->userGroupRepository = $userGroupRepository;
  }


    /**
     * action list
     * @return void
     * 
     */
    public function listAction(): ResponseInterface
    {
      
      $yearSelected           = (int)$_REQUEST['data'][1];
      $info = '';
      $years = [];
      $yearNow = date("Y");
      $dateSelected = $yearNow.'-01-01';
      $dateSelectedT = $dateSelected;
      // Jahren ermitteln an welchen Events existieren
      // \TYPO3\CMS\Core\Utility\DebugUtility::debug($this);
      

      $yearsSQL = $this->eventRepository->findAllYears();
      $year = array_column($yearsSQL, 'year');
      $isAdmin = false;

      // Plugin settings ermitteln
      $showMax = $this->settings['startTop'];
      $startFrom = $this->settings['startFrom'];
      $startTill = $this->settings['startTill'];
      $tag = $this->settings['tag'];
      $title = $this->settings['galleryTitle'];

      // Dropdown Jahre sortieren
      array_multisort($year, SORT_DESC, $yearsSQL);
      foreach ($yearsSQL as $key => $value) {
        array_push($years, $value['year']);
      }
      array_push($years, 'Alle');

      // erkenne ob Admin Gruppe
      $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
      $user = true;//$this->feUserRepository->findByUid($userId);
      // if (isset($user)) {
      //    $groups = $user->getUsergroup();
      //    foreach ($groups as $key => $group) {
      //       if ($group->getTitle() == 'admin') {
      //          $isAdmin = true;
      //       }
      //    }
      // }

      $isAdmin = true;

      $dateFrom = date_create_from_format('Y-m-d', date('Y-m-d'));
      $dateTill = date_create_from_format('Y-m-d', date('Y-m-d', strtotime(' - 6 month')));
      //$dateFrom = date_create_from_format('Y-m-d', date('Y-m-d', strtotime($dateSelected.' - 1 day')));
      if ($startFrom != '' ) {
        $dateSelected = date('Y-m-d', $startFrom);
        $dateFrom = date_create_from_format('Y-m-d', date('Y-m-d', strtotime($dateSelected)));
      }
      if ($startTill != '' ) {
        $dateSelectedT = date('Y-m-d', $startTill);
        $dateTill = date_create_from_format('Y-m-d', date('Y-m-d', strtotime($dateSelectedT)));
      }

      $events = $this->eventRepository->findByDate($dateFrom, $dateTill, $isAdmin);
      // $events = $this->eventRepository->findByTest();
      if (isset ($events) && count($events) < 5 && $showMax != '') {
        //$events = $this->eventRepository->findEventsLimited($isAdmin, (int)$showMax);
        $info = 'Es werden maximal '.$showMax.' Einträge angezeigt';
      }

      if (isset ($events) && count($events) < 1) {
        $info = 'Keine Einträge vorhanden';
      }
      
      $this->view->assignMultiple(['years' => $years, 'events' => $events, 'yearSelected' => $yearSelected, 'hasFilter' => (int)$showMax, 'title'=> $title, 'info' => $info]);
      return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \Casa\CasaTimeline\Domain\Model\Event $event
     * @return void
     */
    public function showAction(\Casa\CasaTimeline\Domain\Model\Event $event): ResponseInterface
    {
        $title = $event->getTitel();
        $description = $event->getDescription();
        // $metaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:title');
        // $metaTagManager->removeProperty('og:title');
        // $metaTagManager->addProperty('og:title', $title);

        $GLOBALS['TSFE']->indexedDocTitle = $title;
        $titleProvider = GeneralUtility::makeInstance(\Casa\CasaTimeline\PageTitle\EventTitleProvider::class);
        $titleProvider->setTitle($title);
        $this->view->assign('event', $event);
        
        return $this->htmlResponse();

    }

    /**
     * action show
     *
     * @param $slug
     * @return void
     */
    public function slugAction($slug = ''): ResponseInterface
    {
      $event = $this->eventRepository->findBySlug($slug);
      \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($event);
      $this->view->assign('event', $event);
      return $this->htmlResponse();
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
     * @param \Casa\CasaTimeline\Domain\Model\Event $newEvent
     * @return void
     */
    public function createAction(\Casa\CasaTimeline\Domain\Model\Event $newEvent): ResponseInterface
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
        $this->eventRepository->add($newEvent);
        $this->redirect('list');
        return $this->htmlResponse();
    }

    /**
     * action edit
     *
     * @param \Casa\CasaTimeline\Domain\Model\Event $event
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $event
     * @return void
     */
    public function editAction(\Casa\CasaTimeline\Domain\Model\Event $event): ResponseInterface
    {
        $this->view->assign('event', $event);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \Casa\CasaTimeline\Domain\Model\Event $event
     * @return void
     */
    public function updateAction(\Casa\CasaTimeline\Domain\Model\Event $event): ResponseInterface
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
        $this->eventRepository->update($event);
        $this->redirect('list');
        return $this->htmlResponse();
    }

    /**
     * action delete
     *
     * @param \Casa\CasaTimeline\Domain\Model\Event $event
     * @return void
     */
    public function deleteAction(\Casa\CasaTimeline\Domain\Model\Event $event): ResponseInterface
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
        $this->eventRepository->remove($event);
        $this->redirect('list');
        return $this->htmlResponse();
    }

    /**
     * action send Reminder Mail
     *
     * @param array $mitglieder
     * @return void
     */
    public function sendmailAction(): ResponseInterface
    {

      $mail = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);

      \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArguments());
      //$userUids = [0 => 'carlos-sampaio-peredo@hotmail.com', 1 => 'carlos.sampaio.peredo@gmail.com'];
      $userUids = [0 => 'carlos.sampaio.peredo@gmail.com'];
      $hotmail = 'carlos-sampaio-peredo@hotmail.com';
      $notReceived = [];
      $countSent = 0;
      //die('Mail');
      foreach ($userUids as $key => $value) {

         $user = $this->feUserRepository->findByUid(1);

         $mailAddress = $user->getEmail();
         $userName = $user->getFirstName().' '.$user->getLastName();
         \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($value);
         //die('W');
        $mail
        ->setSubject('Test von Webmaster')
        ->setFrom(['info@webcasa.tech' => 'Webcasa'])
        ->setTo('carlos.sampaio.peredo@gmail.com');
        //$mail->embedFromPath('/var/www/slackthun.ch/public_html/fileadmin/slackthun/QR-Code.jpg', 'qr-code');
        $variables = ['name' => $userName, 'text' => 'Cool!'];

        $emailHtmlBody = $this->renderFluid('Mail/Sendmail.html', $variables);
        $mail->html($emailHtmlBody);
        //$mail->setReturnPath('info@slackthun.ch');
        $return = $mail->send();
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($return);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($mail);
        if ($mailAddress != '') {

        }else {
            $flashMsg = 'Kein Email Adresse eingetragen - '.$user->getFirstName().' '.$user->getLastName();
            $this->addFlashMessage($flashMsg, '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
        }


      }
      //die('Mail versand Test bis Hotmail funktioniert');
      $this->view->assignMultiple(['receivers' => $receivers]);
      return $this->htmlResponse();
    }

    /**
    * renders fluid template
    *
    * @param array $parameter key=>value pairs, where key is fluid placeholder {key} in the template
    * @return string rendered (html-format) template
    */
    private function renderFluid($templateFile, $parameter)
    {
        //Erstellt ein Objekt View = new..
        $fluidView = $this->objectManager->get(\TYPO3\CMS\Fluid\View\StandaloneView::class);
        $extensionName = $this->request->getControllerExtensionName();
        $fluidView->getRequest()->setControllerExtensionName($extensionName);

        //$fluidView->setControllerContext($this->controllerContext);
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );

        // Holt die Pfade der setup.typoscript, somit ist E-Mail gemäss Backend Pfad. setup.typoscript zwingend!
        $fluidView->setLayoutRootPaths(['EXT:casa_timeline/Resources/Private/Layouts/']);
        $fluidView->setPartialRootPaths(['EXT:casa_timeline/Resources/Private/Partials/']);
        $fluidView->setTemplateRootPaths(['EXT:casa_timeline/Resources/Private/Templates/']);
        $fluidView->setTemplate($templateFile);

        $fluidView->assignMultiple($parameter);

        return $fluidView->render();
    }
}
