<?php
namespace Casa\CasaTimeline\Userfuncs;
use \TYPO3\CMS\Backend\Utility;

class Tca
{

  public function eventTitle(&$parameters)
  {
     $record = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
     $newTitle = date('d.m.Y', $record['eventstartdate']); // date('d.m.Y', strtotime($record['date']));
     $newTitle .= ' - '.$record['titel'];
     $parameters['title'] = $newTitle;
  }
}
