<?php
namespace Casa\CasaTimeline\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
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
 * The repository for Events
 */
class EventRepository extends Repository
{

    public function findByDate(
      $dateFrom = null, 
      $dateTill = null, 
      $isAdmin = false, 
      $tags = [], 
      $keyword = ''
    ): QueryResultInterface
    {
      $query = $this->createQuery();
      $query->getQuerySettings()->setIgnoreEnableFields(TRUE);
      $query->getQuerySettings()->setEnableFieldsToBeIgnored(['starttime','endtime']);

      $constraints = [];
      if ($keyword != '') {
         $constraints = $query->like('titel', '%'.$keyword.'%' );
      }else{
        if (isset($dateFrom) && isset($dateTill)) {
          $constraints = $query->logicalAnd(
              $query->lessThan('eventstartdate', $dateTill->getTimestamp()),
              $query->greaterThan('eventstartdate', $dateFrom->getTimestamp()),  //->format('Y-m-d H:i:s')
          );
        }
      }
      
      if (count($tags) > 0) {
         $constraints = $query->logicalOr(
            $query->in('tags.uid', $tags)
         );
      }

      // if ($isAdmin == false) {
      //    $constraints = $query->equals('share', true);
      // }

      $query->matching($query->logicalAnd($constraints));

      $query->setOrderings(
          [
            'eventstartdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
          ]
      );
      $query->setLimit(5);
      return $query->execute();
    }



    public function findEventsLimited($isAdmin = false, $limit = 5){

      $query = $this->createQuery();

      $query->setLimit($limit);

      $query->setOrderings(
          [
            'eventstartdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
          ]
      );
      if ($isAdmin == false) {
         $constraints[] = $query->equals('share', true);
         $query->matching($query->logicalAnd($constraints));
      }

      return $query->execute();
    }



    public function findAllYears(){

      $query = $this->createQuery();
      $result = $query->statement("SELECT COUNT(*) AS anzahl, FROM_UNIXTIME(eventstartdate, '%Y') as year FROM tx_casatimeline_domain_model_event
                                    GROUP BY FROM_UNIXTIME(eventstartdate, '%Y')
                                    ORDER BY FROM_UNIXTIME(eventstartdate, '%Y') ASC", []);
      return $query->execute(true);
    }

    public function findByTest(){

      $query = $this->createQuery();

      $constraint1 = $query->like('titel', '%Bafa%' );
      $constraint2 = $query->equals('share', true);

      $query->matching($query->logicalAnd($constraint1, $constraint2));
    }
}
