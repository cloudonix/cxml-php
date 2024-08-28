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
     * @return SimpleVerb
     */
    public function play(string $content): SimpleVerb
    {
        return (new SimpleVerb("play"))->content($content);
    }

    /**
     * Create a `<DIAL>` Verb object
     *
     * @param string $content
     *
     * @return SimpleVerb
     */
    public function dial(string $content): SimpleVerb
    {
        return (new SimpleVerb("dial"))->content($content);
    }

    /**
     * Create a `<HANGUP>` Verb object
     *
     * @return SimpleVerb
     */
    public function hangup(): SimpleVerb
    {
        return (new SimpleVerb("hangup"));
    }

    /**
     * Create a `<REDIRECT>` Verb object
     *
     * @param string $content
     *
     * @return SimpleVerb
     */
    public function redirect(string $content): SimpleVerb
    {
        return (new SimpleVerb("redirect"))->content($content);
    }

    /**
     * Create a `<PAUSE>` Verb object
     *
     * @return SimpleVerb
     */
    public function pause(): SimpleVerb
    {
        return (new SimpleVerb("pause"));
    }

    /**
     * Create a `<REJECT>` Verb object
     *
     * @return SimpleVerb
     */
    public function reject(): SimpleVerb
    {
        return (new SimpleVerb("reject"));
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
                if (count($this->verbContent)) {
                    return "<" . $this->verbName . $verbAttributesText . ">" . implode(
                            " ",
                            $this->verbContent
                        ) . "</" . $this->verbName . ">";
                } else {
                    return "<" . $this->verbName . $verbAttributesText . " />";
                }
            }
        } else {
            return "<" . $this->verbName . $verbAttributesText . " />";
        }
    }

}