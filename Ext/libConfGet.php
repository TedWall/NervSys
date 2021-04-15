<?php

/**
 * ConfGet Extension
 *
 * Copyright 2016-2021 秋水之冰 <27206617@qq.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Ext;

use Core\Factory;
use Core\Lib\App;

/**
 * Class libConfGet
 *
 * @package Ext
 */
class libConfGet extends Factory
{
    public App $app;

    public array $conf_pool = [];

    /**
     * libConfGet constructor.
     */
    public function __construct()
    {
        $this->app = App::new();
    }

    /**
     * Load config file (root_path based)
     *
     * @param string $file_name
     *
     * @return $this
     * @throws \Exception
     */
    public function load(string $file_name): self
    {
        if (!is_file($file_path = $this->app->root_path . DIRECTORY_SEPARATOR . $file_name)) {
            throw new \Exception('"' . $file_path . '" NOT found!');
        }

        $this->conf_pool = array_replace_recursive($this->conf_pool, $this->app->parseConf($file_path, true));

        unset($file_name, $file_path);
        return $this;
    }

    /**
     * Use loaded conf data by section name
     *
     * @param string $section
     *
     * @return array
     */
    public function use(string $section): array
    {
        return $this->conf_pool[$section] ?? [];
    }
}