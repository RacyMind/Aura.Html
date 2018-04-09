<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @package Aura.Html
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */

namespace Aura\Html\Helper\Input;

/**
 *
 * An HTML checkbox input.
 *
 * @package Aura.Html
 *
 */
class Checkbox extends AbstractChecked
{
    /**
     *
     * Returns the HTML for the input.
     *
     * @return string
     *
     */
    public function __toString()
    {
        $this->attribs['type'] = 'checkbox';
        // Get unchecked element first. This unsets value_unchecked
        $unchecked = $this->htmlUnchecked();

        // Get the input
        $input = $this->htmlChecked();

        // Unchecked (hidden) element must reside outside the label
        $html = $unchecked . $this->htmlLabel($input);

        if ($this->options) {
            return $this->multiple();
        }

        return $this->indent(0, $html);
    }

    /**
     *
     * Returns the HTML for the "unchecked" part of the input.
     *
     * @return string
     *
     */
    protected function htmlUnchecked()
    {
        if (!isset($this->attribs['value_unchecked'])) {
            return;
        }

        $unchecked = $this->attribs['value_unchecked'];
        unset($this->attribs['value_unchecked']);

        $attribs = array(
            'type' => 'hidden',
            'value' => $unchecked,
            'name' => $this->name
        );

        return $this->void('input', $attribs);
    }

    protected function multiple()
    {
        $html = '';
        $checkbox = clone($this);

        $this->attribs['name'] .= '[]';
        $id=$this->attribs['id'];
        $i=0;
        foreach ($this->options as $value => $label) {
            $i++;
            $this->attribs['id']=$id.$i;
            $this->attribs['value'] = $value;
            $this->attribs['label'] = $label;

            $html .= $checkbox(array(
                'name' => $this->attribs['name'],
                'value' => $this->value,
                'attribs' => $this->attribs
            ));
        }
        return $html;
    }
}
