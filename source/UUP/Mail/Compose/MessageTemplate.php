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
 * Message template.
 * 
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
class MessageTemplate
{

        private $format;
        /**
         * @var string The section delimiter.
         */
        public $delimiter = null;

        /**
         * Constructor.
         * @param string $filename The template file to load.
         */
        public function __construct($filename)
        {
                if (file_exists($filename)) {
                        $this->format = file_get_contents($filename);
                }
        }

        public function __toString()
        {
                return $this->format;
        }

}
