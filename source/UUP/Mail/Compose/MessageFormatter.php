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
 * should contain sprintf() placeholders (i.e. %3$s) that gets substituted. This
 * are the arguments and their ordinal numbering:
 * 
 * $message->title, $delimiter, $message->message, $sections, $message->greeting, $delimiter, $message->footer
 * <ol>
 * <li>The message title.</li>
 * <li>The leading message section.</li>
 * <li>Optional message sections including headers.</li>
 * <li>Message greeting.</li>
 * <li>Message footer.</li>
 * </ol>
 * 
 * Usage example:
 * <code>
 * $composer = new MessageComposer($title, $message);
 * $formatter = new MessageFormatter($htmltpl, $texttpl);
 *
 * $message = new MimeMessage();
 * $message->setHtml($formatter->getHtmlBody($composer));
 * $message->setText($formatter->getTextBody($composer));
 *
 * $message->setTo(...);
 * $message->send();
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
        public function getTextBody($message, $template = "")
        {
                $sections = "";
                $delimiter = "--------------------------------------------------------";

                if (!is_string($template)) {
                        $delimiter = $template->delimiter;
                }
                if (count($message->sections)) {
                        foreach ($message->sections as $header => $content) {
                                $sections .= sprintf("\n** %s\n%s", $header, $delimiter);
                                foreach ($content as $part) {
                                        $sections .= sprintf("\n%s\n", trim($part));
                                }
                        }
                }

                return sprintf($template, $message->title, $delimiter, $message->message, $sections, $message->greeting, $delimiter, $message->footer);
        }

        /**
         * Get mail message body formatted as HTML.
         * @param MessageComposer $message The composed message.
         * @param string|MessageTemplate $template The HTML template.
         * @return string
         */
        public function getHtmlBody($message, $template = "")
        {
                $message->tfooter = sprintf($message->footer, sprintf("<a href=\"%s\">%s</a>", $message->options['base_url'], $message->options['base_url']));

                $sections = "";
                $delimiter = "<br/>";

                if (!is_string($template)) {
                        $delimiter = $template->delimiter;
                }
                if (count($message->sections)) {
                        foreach ($message->sections as $header => $content) {
                                $sections .= sprintf("<p><b><u>%s</u></b>", $header, $delimiter);
                                foreach ($content as $part) {
                                        $part = trim($part);
                                        $part = preg_replace(
                                            array(
                                                "|(https?://[\w-?.&=/]*)\s?|",
                                                "|([\w.-]*?@[\w.-]*)\s?|"
                                            ), array(
                                                "<a href=\"$1\">$1</a> ",
                                                "<a href=\"mailto:$1\">$1</a> "
                                            ), $part);
                                        $sections .= sprintf("<br/>%s<br/>", str_replace("\n", "<br />", $part));
                                }
                                $sections .= "</p>";
                        }
                }

                return sprintf($template, $message->title, str_replace("\n", "<br />", $message->message), $sections, $message->greeting, $message->footer);
        }

}
