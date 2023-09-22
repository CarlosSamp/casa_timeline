<?php

namespace Casa\CasaTimeline\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

/**
 * SlugUtility
 */
class SlugUtility
{

    /**
     * Populate empty slugs in custom table
     *
     * Inspired by TYPO3\CMS\Install\Updates\PopulatePageSlugs
     * Workspaces are not respected here!
     *
     * <?php
     * use Vendor\Extension\Utility\SlugUtility;
     * SlugUtility::populateEmptySlugsInCustomTable('tx_extension_domain_model_test', 'slug');
     *
     * @param string $tableName
     * @param string $fieldName
     * @return void
     */
    public static function populateEmptySlugsInCustomTable($tableName, $fieldName)
    {

        /* @var $connection \TYPO3\CMS\Core\Database\Connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($tableName);
        /* @var $queryBuilder \TYPO3\CMS\Core\Database\Query\QueryBuilder */
        $queryBuilder = $connection->createQueryBuilder();
        /* @var $querBuilder \TYPO3\CMS\Core\Database\Query\QueryBuilder */
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $statement = $queryBuilder
            ->select('*')
            ->from($tableName)
            ->where(
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->eq($fieldName, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($fieldName)
                )
            )
            ->addOrderBy('uid', 'asc')
            ->execute();

        $suggestedSlugs = [];

        $fieldConfig = $GLOBALS['TCA'][$tableName]['columns'][$fieldName]['config'];
        $evalInfo = !empty($fieldConfig['eval']) ? GeneralUtility::trimExplode(',', $fieldConfig['eval'], true) : [];
        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $tableName, $fieldName, $fieldConfig);

        while ($record = $statement->fetch()) {
            $recordId = (int)$record['uid'];
            $pid = (int)$record['pid'];
            $languageId = (int)$record['sys_language_uid'];
            $pageIdInDefaultLanguage = $languageId > 0 ? (int)$record['l10n_parent'] : $recordId;
            $slug = $suggestedSlugs[$pageIdInDefaultLanguage][$languageId] ?? '';

            if (empty($slug)) {
                $slug = $slugHelper->generate($record, $pid);
            }

            $state = RecordStateFactory::forName($tableName)
                ->fromArray($record, $pid, $recordId);
            if ($hasToBeUniqueInSite && !$slugHelper->isUniqueInSite($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
            }
            if ($hasToBeUniqueInPid && !$slugHelper->isUniqueInPid($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
            }

            $connection->update(
                $tableName,
                [$fieldName => $slug],
                ['uid' => $recordId]
            );
        }
    }

}
