<?php
namespace Casa\CasaTimeline\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

class EventTitleProvider extends AbstractPageTitleProvider
{
    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}
