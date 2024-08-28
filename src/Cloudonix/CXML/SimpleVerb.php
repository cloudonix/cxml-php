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
 * @filename: Verb.php
 * @author  : Nir Simionovich <nirs@cloudonix.io>
 * @created : 2024-08-27
 * @link    : https://developers.cloudonix.com/cxml
 * @license : MIT License
 */

namespace Cloudonix\CXML;

class SimpleVerb implements VerbInterface
{
    protected string $verbName = "";
    protected array $verbAttributes = [];
    protected string|null|array $verbContent = null;

    /**
     * CXML SimpleVerb Constructor
     *
     * @param string|null $verbName
     */
    public function __construct(null|string $verbName = null)
    {
        if (!is_null($verbName)) {
            $this->verbName = strtoupper($verbName);
        }
    }

    public function __destruct()
    {
    }

    /**
     * Create a `<PLAY>` Verb object
     *
     * @param string $content
     *
     * @return CompoundVerb|bool|$this
     */
    public function play(string $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->setVerb("play")->content($content);
    }

    /**
     * Create a `<DIAL>` Verb object
     *
     * @param string $content
     *
     * @return CompoundVerb|bool|$this
     */
    public function dial(string $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->setVerb("dial")->content($content);
    }

    /**
     * Create a `<HANGUP>` Verb object
     *
     * @return SimpleVerb|CompoundVerb|bool
     */
    public function hangup(): SimpleVerb|CompoundVerb|bool
    {
        return $this->setVerb("hangup");
    }

    /**
     * Create a `<REDIRECT>` Verb object
     *
     * @param string $content
     *
     * @return CompoundVerb|bool|$this
     */
    public function redirect(string $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->setVerb("redirect")->content($content);
    }

    /**
     * Create a `<PAUSE>` Verb object
     *
     * @return SimpleVerb|CompoundVerb|bool
     */
    public function pause(): SimpleVerb|CompoundVerb|bool
    {
        return $this->setVerb("pause");
    }

    /**
     * Create a `<REJECT>` Verb object
     *
     * @return SimpleVerb|CompoundVerb|bool
     */
    public function reject(): SimpleVerb|CompoundVerb|bool
    {
        return $this->setVerb("reject");
    }

    /**
     * Create a generic CXML Verb Object
     *
     * @param string $verbName
     *
     * @return SimpleVerb
     */
    private function setVerb(string $verbName): SimpleVerb
    {
        return new SimpleVerb($verbName);
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
     * Set the content for the created CXML Verb.
     *
     * @param $verbContent
     *
     * @return $this
     */
    public function content($verbContent): self
    {
        $this->verbContent = $verbContent;
        return $this;
    }

    /**
     * Output CXML Verb Object as CXML Plain-Text String
     *
     * @return string
     */
    public function __toString(): string
    {
        $verbAttributesText = "";
        $verbAttributesIndex = 0;
        if (count($this->verbAttributes) > 0) {
            $verbAttributesText .= " ";
        }
        foreach ($this->verbAttributes as $attribute => $value) {
            $verbAttributesText .= "${attribute}=\"${value}\"";
            $verbAttributesIndex++;
            if ($verbAttributesIndex < count($this->verbAttributes)) {
                $verbAttributesText .= " ";
            }
        }
        if (!is_null($this->verbContent)) {
            if (!is_array($this->verbContent)) {
                return "<" . $this->verbName . $verbAttributesText . ">" . $this->verbContent . "</" . $this->verbName . ">";
            } else {
                return "<" . $this->verbName . $verbAttributesText . ">" . implode(" ", $this->verbContent) . "</" . $this->verbName . ">";
            }
        } else {
            return "<" . $this->verbName . $verbAttributesText . " />";
        }
    }

}