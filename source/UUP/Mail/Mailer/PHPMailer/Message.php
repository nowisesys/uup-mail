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

namespace UUP\Mail\Mailer\PHPMailer;

use UUP\Mail\Compose\MessageComposer,
    UUP\Mail\Compose\MessageFormatter;

/**
 * Message implementation for PHPMailer.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
class Message extends \PHPMailer implements \UUP\Mail\Message
{

        /**
         * Constructor.
         * @param MessageComposer $composer
         * @param MessageFormatter $formatter
         */
        public function __construct($composer, $formatter)
        {
                parent::__construct();
                $this->Body = $formatter->getHtmlBody($composer);
                $this->AltBody = $formatter->getTextBody($composer);
        }

        public function addTo($addr, $name = null)
        {
                $this->addAddress($addr, $name);
        }

        public function attachData($data, $file = null, $type = null)
        {
                $path = tempnam(sys_get_temp_dir(), 'uup_mail');
                file_put_contents($path, $data);
                $this->addAttachment($path, $file, 'base64', $type);
        }

        public function attachFile($file, $type = null)
        {
                $this->addAttachment($file, basename($file), 'base64', $type);
        }

        public function setHtml($body)
        {
                $this->Body = $body;
        }

        public function setText($body)
        {
                $this->AltBody = $body;
        }

        public function setSubject($string)
        {
                $this->Subject = $string;
        }

}
