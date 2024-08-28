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
 * @filename: Responder.php
 * @author  : Nir Simionovich <nirs@cloudonix.io>
 * @created : 2024-08-27
 * @link    : https://developers.cloudonix.com/cxml
 * @license : MIT License
 */


namespace Cloudonix\CXML;

final class Response
{
    private array $payloadArray = [];
    public SimpleVerb $nest;

    /**
     * CXML Response Constructor
     */
    public function __construct()
    {
        $this->nest = new SimpleVerb();
    }

    public function __destruct()
    {
    }

    /**
     * Add a `<PLAY>` Verb to CXML response.
     *
     * @param string $content
     *
     * @return SimpleVerb
     */
    public function play(string $content): SimpleVerb
    {
        return $this->appendVerb((new SimpleVerb("play"))->content($content));
    }

    /**
     * Add a `<DIAL>` Verb to CXML Response.
     *
     * @param string $content
     *
     * @return SimpleVerb
     */
    public function dial(string $content): SimpleVerb
    {
        return $this->appendVerb((new SimpleVerb("dial"))->content($content));
    }

    /**
     * Add a `<HANGUP>` Verb to CXML Response.
     *
     * @return SimpleVerb
     */
    public function hangup(): SimpleVerb
    {
        return $this->appendVerb(new SimpleVerb("hangup"));
    }

    /**
     * Add a `<GATHER>` Compound Verb to CXML Response.
     *
     * @param array $content
     *
     * @return CompoundVerb
     */
    public function gather(array $content): CompoundVerb
    {
        return $this->appendVerb((new CompoundVerb("hangup"))->content($content));
    }

    /**
     * Add a `<REDIRECT>` Verb to CXML Response.
     *
     * @param string $content
     *
     * @return SimpleVerb
     */
    public function redirect(string $content): SimpleVerb
    {
        return $this->appendVerb((new SimpleVerb("redirect"))->content($content));
    }

    /**
     * Add a `<START>` Compound Verb to CXML Response.
     *
     * @param array $content
     *
     * @return CompoundVerb
     */
    public function start(array $content): CompoundVerb
    {
        return $this->appendVerb((new CompoundVerb("start"))->content($content));
    }

    /**
     * Add a `<PAUSE>` Verb to CXML Response.
     *
     * @return SimpleVerb
     */
    public function pause(): SimpleVerb
    {
        return $this->appendVerb(new SimpleVerb("pause"));
    }

    /**
     * Add a `<RECORD>` Compound Verb to CXML Response.
     *
     * @param array $content
     *
     * @return CompoundVerb
     */
    public function record(array $content): CompoundVerb
    {
        return $this->appendVerb((new CompoundVerb("record"))->content($content));
    }

    /**
     * Add a `<REJECT>` Verb to CXML Response.
     *
     * @return SimpleVerb
     */
    public function reject(): SimpleVerb
    {
        return $this->appendVerb(new SimpleVerb("reject"));
    }

    /**
     * Append a CXML Verb to CXML Response
     *
     * @param SimpleVerb|CompoundVerb $verbObject
     *
     * @return SimpleVerb|CompoundVerb|bool
     */
    private function appendVerb(SimpleVerb|CompoundVerb $verbObject): SimpleVerb|CompoundVerb|bool
    {
        $this->payloadArray[] = $verbObject;
        return $this->payloadArray[count($this->payloadArray) - 1];
    }

    /**
     * Output CXML Response as CXML Plain-Text String
     *
     * @return string
     */
    public function __toString(): string
    {
        $cxmlResponse = "<Response>\n";
        foreach ($this->payloadArray as $verbObject) {
            $cxmlResponse .= "  " . $verbObject ."\n";
        }
        $cxmlResponse .= "</Response>";
        return $cxmlResponse;
    }

}