<?php
declare(strict_types=1);

namespace Hypershop\Shortcodes\Model\Observer\Cms;

use Hypershop\Shortcodes\Helper\Data;
use Magento\Cms\Model\Page;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class PageRender implements ObserverInterface
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var Page $page */
        $page = $observer->getPage();
        $content = $page->getContent();
        $content = $this->helper->removeWrappingParagraphs($content);
        $content = $this->helper->addShortcodes($content);
        $page->setContent($content);
    }
}
