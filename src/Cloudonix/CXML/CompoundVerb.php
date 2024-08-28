<?php
/**
 *  ██████╗██╗      ██████╗ ██╗   ██╗██████╗  ██████╗ ███╗   ██╗██╗██╗  ██╗
 * ██╔════╝██║     ██╔═══██╗██║   ██║██╔══██╗██╔═══██╗████╗  ██║██║╚██╗██╔╝
 * ██║     ██║     ██║   ██║██║   ██║██║  ██║██║   ██║██╔██╗ ██║██║ ╚███╔╝
 * ██║     ██║     ██║   ██║██║   ██║██║  ██║██║   ██║██║╚██╗██║██║ ██╔██╗
 * ╚██████╗███████╗╚██████╔╝╚██████╔╝██████╔╝╚██████╔╝██║ ╚████║██║██╔╝ ██╗
 *  ╚═════╝╚══════╝ ╚═════╝  ╚═════╝ ╚═════╝  ╚═════╝ ╚═╝  ╚═══╝╚═╝╚═╝  ╚═╝
 *
 * @project : cxml-php
 * @filename: ComplexVerb.php
 * @author  : Nir Simionovich <nirs@cloudonix.io>
 * @created : 2024-08-27
 * @link    : https://developers.cloudonix.com/cxml
 * @license : MIT License
 */

namespace Cloudonix\CXML;

class CompoundVerb implements VerbInterface
{
    protected string $verbName = "";
    protected array $verbAttributes = [];
    protected null|array $verbContent = null;

    /**
     * CXML CompoundVerb Constructor
     *
     * @param string $verbName
     */
    public function __construct(string $verbName)
    {
        $this->verbName = strtoupper($verbName);
    }

    public function __destruct()
    {
    }

    /**
     * Set attributes for the created CXML Verb.
     *
     * @param array $verbAttributes
     *
     * @return $this
     */
    public function attributes(array $verbAttributes): self
    {
        $this->verbAttributes = $verbAttributes;
        return $this;
    }

    /**
     * Set content for the created CXML Verb.
     *
     * @param array|null $verbObjects
     *
     * @return $this
     */
    public function content(array|null $verbObjects): self
    {
        if (!is_null($verbObjects)) {
            $this->verbContent = [];
            foreach ($verbObjects[0] as $verbObject) {
                $this->verbContent[] = $verbObject;
            }
        }
        return $this;
    }

    /**
     * Output CXML CompoundVerb Object as CXML Plain-Text String
     *
     * @return string
     */
    public function __toString()
    {
        $verbAttributesText = "";
        $verbAttributesIndex = 0;

        if (count($this->verbAttributes) > 0) $verbAttributesText .= " ";
        foreach ($this->verbAttributes as $attribute => $value) {
            $verbAttributesText .= "${attribute}=\"${value}\"";
            $verbAttributesIndex++;
            if ($verbAttributesIndex < count($this->verbAttributes)) $verbAttributesText .= " ";
        }

        if (!is_null($this->verbContent)) {
            $nestedVerbs = "";
            foreach ($this->verbContent as $nestedVerb) {
                $nestedVerbs .= "\n    " . $nestedVerb;
            }
            return "<" . $this->verbName . $verbAttributesText .">" . $nestedVerbs . "\n  </" . $this->verbName .">";
        } else {
            return "<" . $this->verbName . " ". $verbAttributesText ."/>";
        }
    }
}