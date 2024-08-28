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

use Cloudonix\CXML\CompoundVerb;
use Cloudonix\CXML\SimpleVerb;
use Cloudonix\CXML\Verbs;

final class Response
{
    private array $payloadArray = [];
    public SimpleVerb $nest;

    /**
     * CXML Response Constructor
     *
     *
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
     * @return \Cloudonix\CXML\SimpleVerb|\Cloudonix\CXML\CompoundVerb|bool
     */
    public function play(string $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("play")->content($content);
    }

    /**
     * Add a `<DIAL>` Verb to CXML Response.
     *
     * @param string $content
     *
     * @return \Cloudonix\CXML\SimpleVerb|\Cloudonix\CXML\CompoundVerb|bool
     */
    public function dial(string $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("dial")->content($content);
    }

    /**
     * Add a `<HANGUP>` Verb to CXML Response.
     *
     * @return \Cloudonix\CXML\SimpleVerb|\Cloudonix\CXML\CompoundVerb|bool
     */
    public function hangup(): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("hangup");
    }

    /**
     * Add a `<GATHER>` Compound Verb to CXML Response.
     *
     * @param array $content
     *
     * @return SimpleVerb|CompoundVerb|bool
     */
    public function gather(array $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("gather")->content($content);
    }

    /**
     * Add a `<REDIRECT>` Verb to CXML Response.
     *
     * @param string $content
     *
     * @return SimpleVerb|CompoundVerb|bool
     */
    public function redirect(string $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("redirect")->content($content);
    }

    /**
     * Add a `<START>` Compound Verb to CXML Response.
     *
     * @param array $content
     *
     * @return \Cloudonix\CXML\SimpleVerb|\Cloudonix\CXML\CompoundVerb|bool
     */
    public function start(array $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("start")->content($content);
    }

    /**
     * Add a `<PAUSE>` Verb to CXML Response.
     *
     * @return \Cloudonix\CXML\SimpleVerb|\Cloudonix\CXML\CompoundVerb|bool
     */
    public function pause(): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("pause");
    }

    /**
     * Add a `<RECORD>` Compound Verb to CXML Response.
     *
     * @param array $content
     *
     * @return \Cloudonix\CXML\SimpleVerb|\Cloudonix\CXML\CompoundVerb|bool
     */
    public function record(array $content): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("record")->content($content);
    }

    /**
     * Add a `<REJECT>` Verb to CXML Response.
     *
     * @return \Cloudonix\CXML\SimpleVerb|\Cloudonix\CXML\CompoundVerb|bool
     */
    public function reject(): SimpleVerb|CompoundVerb|bool
    {
        return $this->addVerb("reject");
    }

    /**
     * Add a CXML Verb to CXML Response
     *
     * @param string $verbName
     *
     * @return \Cloudonix\CXML\SimpleVerb|\Cloudonix\CXML\CompoundVerb|bool
     */
    private function addVerb(string $verbName): SimpleVerb|CompoundVerb|bool
    {
        $verbValidator = new Verbs();
        if ($verbValidator->is_simple($verbName)) {
            $verb = new SimpleVerb($verbName);
        } else if ($verbValidator->is_compound($verbName)) {
            $verb = new CompoundVerb($verbName);
        } else return false;

        $this->payloadArray[] = $verb;
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