<?php

/*
 * Copyright (C) 2014 Anders Lövgren (QNET/BMC CompDept).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace UUP\Mail\Compose;

/**
 * Format message using templates.
 * 
 * The template could be defined by a string or an template object. The template 
 * should contain sprintf() placeholders (i.e. %3$s) that gets substituted. 
 * 
 * These are the arguments and their ordinal numbering as passed to the template
 * string for substitution:
 * 
 * <ol>
 * <li>The message title.</li>
 * <li>The leading message section.</li>
 * <li>Optional message sections including their headers.</li>
 * <li>The message greeting.</li>
 * <li>The message footer.</li>
 * </ol>
 * 
 * Example plain text message template:
 * <code>
 * $texttpl = "%1$s\n%2$s\n\n%3$s\n\n// %4$s\n\n%5$s\n";
 * </code>
 * 
 * Example showing different ways of formatting composed messages:
 * <code>
 * // Load template from file:
 * $htmltpl = new MessageTemplate('template/html.tpl');
 * $texttpl = new MessageTemplate('template/text.tpl');
 * 
 * // Initialize with templates at construction time:
 * $formatter = new MessageFormatter($htmltpl, $texttpl);
 * $message->setHtml($formatter->getHtmlBody($composer);
 * $message->setText($formatter->getHtmlBody($composer);
 * 
 * // Pass templates as argument at formatting time:
 * $formatter = new MessageFormatter();
 * $message->setHtml($formatter->getHtmlBody($composer, $htmltpl);
 * $message->setText($formatter->getHtmlBody($composer, $texttpl);
 * </code>
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
class MessageFormatter
{

        private $html;
        private $text;

        /**
         * Constructor.
         * @param string|MessageTemplate $html The HTML template.
         * @param string|MessageTemplate $text The plain text template.
         */
        public function __construct($html = "", $text = "")
        {
                $this->html = $html;
                $this->text = $text;
        }

        /**
         * Set the HTML template.
         * @param string|MessageTemplate $html The HTML template.
         */
        public function setHtmlTemplate($template)
        {
                $this->html = $template;
        }

        /**
         * Set the plain text template.
         * @param string|MessageTemplate $text The plain text template.
         */
        public function setTextTemplate($template)
        {
                $this->text = $template;
        }

        /**
         * Get mail message body formatted as plain text.
         * @param MessageComposer $message The composed message.
         * @param string|MessageTemplate $template The plain text template.
         * @return string
         */
        public function getTextBody($message, $template = null)
        {
                $sections = "";
                $delimiter = "--------------------------------------------------------";

                if (!isset($template)) {
                        $template = $this->text;
                }
                if (!is_string($template) && isset($template->delimiter)) {
                        $delimiter = $template->delimiter;
                }

                $template = str_replace(array('$$delimiter'), array($delimiter), $template);

                if (count($message->sections)) {
                        foreach ($message->sections as $header => $content) {
                                $sections .= sprintf("\n** %s\n%s", $header, $delimiter);
                                foreach ($content as $part) {
                                        $sections .= sprintf("\n%s\n", trim($part));
                                }
                        }
                }

                return sprintf($template, $message->title, $message->message, $sections, $message->greeting, $message->footer);
        }

        /**
         * Get mail message body formatted as HTML.
         * @param MessageComposer $message The composed message.
         * @param string|MessageTemplate $template The HTML template.
         * @return string
         */
        public function getHtmlBody($message, $template = null)
        {
                $message->tfooter = sprintf($message->footer, sprintf("<a href=\"%s\">%s</a>", $message->options->app_base, $message->options->app_base));

                $sections = "";
                $delimiter = "<br/>";

                if (!isset($template)) {
                        $template = $this->html;
                }
                if (!is_string($template) && isset($template->delimiter)) {
                        $delimiter = $template->delimiter;
                }

                $subst = function($part) {
                        return preg_replace(
                            array(
                                "|(https?://[\w-?.&=/]*)\s?|",
                                "|([\w.-]*?@[\w.-]*)\s?|"
                            ), array(
                                "<a href=\"$1\">$1</a> ",
                                "<a href=\"mailto:$1\">$1</a> "
                            ), $part);
                };

                if (count($message->sections)) {
                        $sections .= "<div class=\"cont\">";
                        foreach ($message->sections as $header => $content) {
                                $sections .= sprintf("<div class=\"head\">%s</div><div class=\"sect\">", $header, $delimiter);
                                foreach ($content as $part) {
                                        $sections .= sprintf("<div class=\"part\">%s</div>", str_replace("\n", "<br/>", $subst(trim($part))));
                                }
                                $sections .= "</div>";
                        }
                        $sections .= "</div>";
                }

                return sprintf($template, $message->title, str_replace("\n", "<br />", $message->message), $sections, $subst($message->greeting), $subst($message->footer));
        }

}
