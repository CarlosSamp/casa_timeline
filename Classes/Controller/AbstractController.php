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

abstract class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

}

