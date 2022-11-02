<?php
declare(strict_types=1);

namespace Hypershop\Shortcodes\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\View\LayoutInterface;

class Data extends AbstractHelper
{
    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * @param Context $context
     * @param LayoutInterface $layout
     */
    public function __construct(
        Context $context,
        LayoutInterface $layout
    ) {
        parent::__construct($context);
        $this->layout = $layout;
    }

    /**
     * Remove wrapping <p></p> & <div></div> tags around widgets
     *
     * @param $content
     * @return array|string|string[]|null
     */
    public function removeWrappingParagraphs($content)
    {
        // Remove wrapping paragraphs around widgets:
        $content = preg_replace('/\<p\>{{(.*?)}}\<\/p\>/', '{{$1}}', $content);

        // Remove div around widgets
        $content = preg_replace('/\<div\>{{(.*?)}}\<\/div\>/', '{{$1}}', $content);

        // Remove empty paragraphs:
        $content = preg_replace('/<p>(|\s*|&nbsp;|\n)<\/p>/', '', $content);

        // Remove empty divs:
        $content = preg_replace('/<div>(|\s*|&nbsp;|\n)<\/div>/', '', $content);

        return $content;
    }

    /**
     * Adds shortcodes from layout XML files
     *
     * @param $content
     * @return array|mixed|string|string[]
     */
    public function addShortcodes($content)
    {
        $shortcodesBlock = $this->layout->getBlock('shortcodes');
        if ($shortcodesBlock) {
            $items = $shortcodesBlock->getList();

            if (count($items) > 0) {
                preg_match_all("/\[([^\]]*)\]/", $content, $matches);
                $matchesInContent = $matches[1];

                if (count($matchesInContent) > 0) {
                    foreach ($items as $item) {
                        if (key_exists('shortcode', $item) && key_exists('class', $item)) {
                            $shortcode = $item['shortcode'];
                            $class = $item['class'];
                            $shortcodeExtraClass = null;

                            foreach ($matchesInContent as $matchInContent) {
                                if (strpos($matchInContent, $shortcode) !== false && strpos($matchInContent, 'extra-class') !== false) {
                                    preg_match('/^[^"]*"([^"]*)"$/', $matchInContent, $matches);
                                    if (count($matches) > 0) {
                                        $shortcodeExtraClass = $matches[1];
                                        $content = str_replace('<p>[' . $shortcode . ' extra-class="' . $shortcodeExtraClass . '"]</p>', '<div class="' . $class . ' ' . $shortcodeExtraClass .'" data-shortcode="' . $shortcode . '">', $content);
                                    }
                                }
                            }

                            $content = str_replace('<p>[' . $shortcode . ']</p>', '<div class="' . $class . '" data-shortcode="' . $shortcode . '">', $content);

                            // Transform [/shortcode] into closing div
                            $content = str_replace('<p>[/' . $shortcode . ']</p>', '</div>', $content);
                        }
                    }
                }
            }
        }

        return $content;
    }
}
