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

namespace UUP\Mail\Pear;

use UUP\Mail\Message;

require_once 'Mail.php';
require_once 'Mail/mime.php';

/**
 * Create a PEAR Mail_Mime message.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
class PearMessage extends \Mail_mime implements Message
{

        /**
         * Constructor.
         * @param MessageComposer $composer
         * @param MessageFormatter $formatter
         * @param array $params Params for parent constructor.
         */
        public function __construct($composer, $formatter, $params = array())
        {
                parent::Mail_mime($params);
                self::setHtml($formatter->getHtmlBody($composer));
                self::setText($formatter->getTextBody($composer));
        }

        public function attachData($data, $file = null, $type = null)
        {
                parent::addAttachment($data, $type, $file, false);
        }

        public function attachFile($file, $type = null)
        {
                parent::addAttachment($file, $type, basename($file), true);
        }

        public function setHtml($body)
        {
                parent::setHTMLBody($body);
        }

        public function setText($body)
        {
                parent::setTXTBody($body);
        }

        public function setFrom($email, $name = null)
        {
                parent::setFrom($email);
        }

        public function addTo($email, $name = null)
        {
                parent::addTo($email);
        }

        public function addBcc($addr, $name = null)
        {
                parent::addBcc($email);
        }

        public function addCc($addr, $name = null)
        {
                parent::addCc($email);
        }

        public function setSubject($string)
        {
                parent::setSubject($string);
        }

}
