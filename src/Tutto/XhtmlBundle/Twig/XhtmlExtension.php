<?php
namespace Tutto\XhtmlBundle\Twig;

use Tutto\XhtmlBundle\Lib\SimpleText;
use Tutto\XhtmlBundle\Lib\SingleTag;
use Tutto\XhtmlBundle\Lib\Tag;
use Tutto\XhtmlBundle\Lib\TagInterface;
use \Twig_Extension;
use \Twig_SimpleFunction;

/**
 * Class XhtmlExtension
 * @package Tutto\XhtmlBundle\Twig
 */
class XhtmlExtension extends Twig_Extension {
    /**
     * @return array
     */
    public function getFunctions() {
        return array(
            new Twig_SimpleFunction('xhtml', [$this, 'xhtml'])
        );
    }

    /**
     * @return $this
     */
    public function xhtml() {
        return $this;
    }

    /**
     * @param TagInterface $tag
     * @return string
     */
    public function render(TagInterface $tag) {
        if ($tag instanceof SimpleText) {
            return $this->renderSimpleText($tag);
        } elseif ($tag instanceof SingleTag) {
            return $this->renderSingleTag($tag);
        } else {
            /** @var Tag $tag */
            $xhtml = '<'.$tag->getName().$this->mergeAttributes($tag->getAttributes()).'>';
            $xhtml.= $this->renderChildren($tag->getChildren());
            $xhtml.= '</'.$tag->getName().'>';

            return $xhtml;
        }
    }

    /**
     * @param SimpleText $tag
     * @return string
     */
    protected function renderSimpleText(SimpleText $tag) {
        $xhtml = $tag->getText();
        $xhtml.= $this->renderChildren($tag->getChildren());

        return $xhtml;
    }

    /**
     * @param SingleTag $tag
     * @return string
     */
    protected function renderSingleTag(SingleTag $tag) {
        $xhtml = '<'.$tag->getName().$this->mergeAttributes($tag->getAttributes()).' />';
        $xhtml.= $this->renderChildren($tag->getChildren());

        return $xhtml;
    }

    /**
     * @param array $attributes
     * @return string
     */
    protected function mergeAttributes(array $attributes) {
        $attr = '';
        foreach ($attributes as $key => $value) {
            if (!empty($value)) {
                if (is_array($value)) {
                    $value = ltrim(implode(' ', $value));
                }

                $attr .= "{$key}=\"{$value}\" ";
            }
        }

        return !empty($attr) ? ' '.trim($attr) : '';
    }

    /**
     * @param array $children
     * @return string
     */
    protected function renderChildren(array $children) {
        $xhtml = '';
        foreach ($children as $child) {
            $xhtml.= $this->render($child);
        }

        return $xhtml;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'xhtml_extension';
    }
}