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

namespace UUP\Mail;

/**
 * The mail message interface.
 * 
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
interface Message
{

        /**
         * Set message subject.
         * @param string $string The subject line.
         */
        function setSubject($string);

        /**
         * Set From address.
         * @param string $addr The email address.
         * @param string $name Optional name.
         */
        function setFrom($addr, $name = null);

        /**
         * Add To address.
         * @param string $addr The email address.
         * @param string $name Optional name.
         */
        function addTo($addr, $name = null);

        /**
         * Add Cc address.
         * @param string $addr The email address.
         * @param string $name Optional name.
         */
        function addCc($addr, $name = null);

        /**
         * Add Bcc address.
         * @param string $addr The email address.
         * @param string $name Optional name.
         */
        function addBcc($addr, $name = null);

        /**
         * Set HTML body.
         * @param string $body The message part body.
         */
        function setHtml($body);

        /**
         * Set plain text body.
         * @param string $body The message part body.
         */
        function setText($body);

        /**
         * Attach file.
         * 
         * @param string $file The filename.
         * @param string $type The content type.
         */
        function attachFile($file, $type = null);

        /**
         * Attach data.
         * 
         * @param string $data The data to attach.
         * @param string $file The filename.
         * @param string $type The content type.
         */
        function attachData($data, $file = null, $type = null);
}
