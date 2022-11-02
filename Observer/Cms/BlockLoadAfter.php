<?php
declare(strict_types=1);

namespace Hypershop\Shortcodes\Model\Observer\Cms;

use Hypershop\Shortcodes\Helper\Data;
use Magento\Cms\Model\Block;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class BlockLoadAfter implements ObserverInterface
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
        /** @var Block $block */
        $block = $observer->getObject();
        $content = $block->getContent();
        $content = $this->helper->removeWrappingParagraphs($content);
        $content = $this->helper->addShortcodes($content);
        $block->setContent($content);
    }
}
