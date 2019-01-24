<?php

/*
 * Copyright (C) 2014 Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University).
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
 * Default message footer.
 */
if (!defined('UUP_MAIL_MESSAGE_FOOTER')) {
        define('UUP_MAIL_MESSAGE_FOOTER', 'This message was automatic generated and sent out by %s at %s');
}
/**
 * Default message greeter.
 */
if (!defined('UUP_MAIL_MESSAGE_GREETER')) {
        define('UUP_MAIL_MESSAGE_GREETER', 'Cheers, %s (%s)');
}

/**
 * Message composer.
 * 
 * This class builds an abstract representation of the mail message body. The
 * message body consist of these logical parts:
 *
 *   title        (required)
 *   message      (required)
 *   sections     (optional)
 *   greeting     (required)
 *   footer       (required)
 *
 * The sections part is contructed by the sections member. Each section consists
 * of an header and one or more parts. Each part is rendered as an paragraph
 * split by two newlines (&lt;br&gt;-tags in HTML-mode).
 * 
 * Use together with the message template class to generate HTML and plain text 
 * message bodies. This class was designed to be used as the parent class for 
 * specialized message classes:
 * 
 * <code>
 * class ConfirmationRequiredMessage extends MessageComposer
 * {
 *      public function __construct()
 *      {
 *              parent::__construct(_("Confirmation Required"), _("..."));
 *              parent::addSection(_("Confimation:"));
 *              parent::addContent(_("..."));
 *      }
 * }
 * </code>
 * 
 * @property-read string $title The message title.
 * @property-read string $message The leading message section.
 * @property-read array $sections Optional message sections as associative array.
 * @property-read string $greeting The message greeting.
 * @property-read string $footer The message footer.
 * @property-read MessageOptions $options The message options object.
 *
 * @author Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University)
 * @package UUP
 * @subpackage Mail
 */
class MessageComposer
{

        private $data;

        /**
         * Constructor.
         * 
         * The $options array can have these key/value pairs. Some of them can be
         * left out if greeter(1) and/or footer(2) message is set.
         * <code>
         * $options = array(
         *      "contact_name" => "Anders Lövgren",                  // (1)
         *      "contact_addr" => "anders.lovgren@bmc.uu.se",        // (1)
         *      "app_name"     => "Web application name",            // (2)
         *      "app_base"     => "http://localhost/webapp"          // (2)
         * );
         * </code>
         * @param string $title The message title.
         * @param string $message The leading message section.
         * @param array|MessageOptions $options Message options object or array.
         */
        public function __construct($title, $message, $options = array())
        {
                $this->data = (object) array();

                $this->data->title = $title;
                $this->data->message = $message;
                $this->data->sections = array();

                $this->data->options = self::getOptions($options);

                $this->data->footer = $this->getFooter();
                $this->data->greeting = $this->getGreeting();
        }

        public function __get($name)
        {
                if (isset($this->data->$name)) {
                        return $this->data->$name;
                }
        }

        /**
         * Add a new section.
         * @param string $header The section header.
         */
        public function addSection($header)
        {
                $this->data->header = $header;
                $this->data->sections[$header] = array();
        }

        /**
         * Add content to current section.
         * @param string $content The content text.
         */
        public function addContent($content)
        {
                $this->data->sections[$this->header][] = $content;
        }

        /**
         * Replace content in section named by header.
         * @param string $header The section header.
         * @param string $content The content text.
         */
        public function setContent($header, $content)
        {
                $this->data->header = $header;
                $this->data->sections[$header] = array($content);
        }

        /**
         * Set message greeting.
         * @param string $str The greeting text.
         */
        public function setGreeting($str)
        {
                $this->data->greeting = $str;
        }

        /**
         * Set message footer.
         * @param string $str The footer text.
         */
        public function setFooter($str)
        {
                $this->data->footer = $str;
        }

        //
        // Generate the message footer using default format.
        // 
        private function getFooter()
        {
                return sprintf(UUP_MAIL_MESSAGE_FOOTER, $this->data->options->app_name, $this->data->options->app_base);
        }

        //
        // Generate the message greeter using default format.
        //
        private function getGreeting()
        {
                return sprintf(UUP_MAIL_MESSAGE_GREETER, $this->data->options->contact_name, $this->data->options->contact_addr);
        }

        // 
        // Return same message options object or a copy of the default options
        // object merged with the passed options array.
        // 
        private static function getOptions($options)
        {
                if ($options instanceof MessageOptions) {
                        return $options;
                } else {
                        $standard = clone MessageOptions::instance();
                        return $standard->merge($options);
                }
        }

}
