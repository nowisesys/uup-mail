<?php

/*
 * Copyright (C) 2014 Anders Lövgren (Computing Department at BMC, Uppsala University).
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
 * Shared mail message configuration.
 * 
 * @property-read string $contact_name The contact name.
 * @property-read string $contact_addr The contact address.
 * @property-read string $app_base The application base URL.
 * @property-read string $app_name The application name.
 * 
 * @author Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University)
 * @package UUP
 * @subpackage Mail
 */
class MessageOptions
{

        private $data = array();
        private static $config;

        /**
         * Constructor.
         * 
         * Initialize the property bag with defaults.
         * @param array $options The message config options.
         */
        public function __construct($options = array())
        {
                $this->data = array_merge(self::defaults(), $options);
        }

        public function __get($name)
        {
                if (isset($this->data[$name])) {
                        return $this->data[$name];
                }
        }

        /**
         * Merge options with this configuration.
         * @param array $options The message config options.
         * @return MessageOptions 
         */
        public function merge($options)
        {
                $this->data = array_merge($this->data, $options);
                return $this;
        }

        /**
         * Get shared instance.
         * 
         * The shared instance will be created if not set and populated with
         * default values from current server context.
         * 
         * @return MessageOptions
         */
        public static function instance()
        {
                if (!isset(self::$config)) {
                        self::$config = new MessageOptions(self::defaults());
                }
                return self::$config;
        }

        /**
         * Replace shared instance.
         * @param MessageOptions $config
         */
        public static function setInstance($config)
        {
                self::$config = $config;
        }

        private static function lookup($key, $def = '')
        {
                if (defined($key)) {
                        return $key;
                } elseif (isset($GLOBALS[$key])) {
                        return $GLOBALS[$key];
                } elseif (isset($_SERVER[$key])) {
                        return $_SERVER[$key];
                } else {
                        return $def;
                }
        }

        /**
         * Get default options.
         * @return array
         */
        public static function defaults()
        {
                return array(
                        'contact_addr' => self::lookup('SERVER_ADMIN', 'root@localhost'),
                        'contact_name' => self::lookup('SERVER_ADMIN', 'System manager'),
                        'app_name'     => 'UUP Mail',
                        'app_base'     => self::lookup('SERVER_NAME', 'localhost')
                );
        }

}
