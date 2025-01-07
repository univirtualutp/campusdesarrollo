<?php
/*
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

defined('MOODLE_INTERNAL') || die();

$definitions = [
    'courses' => [
        'mode' => cache_store::MODE_REQUEST,
        'simplekeys' => true,
    ],
    'labels' => [
        'mode' => cache_store::MODE_REQUEST,
        'simplekeys' => true,
    ],
    'messages' => [
        'mode' => cache_store::MODE_REQUEST,
        'simplekeys' => true,
    ],
    'usercourseids' => [
        'mode' => cache_store::MODE_REQUEST,
        'simplekeys' => true,
    ],
    'userlabelids' => [
        'mode' => cache_store::MODE_REQUEST,
        'simplekeys' => true,
    ],
    'users' => [
        'mode' => cache_store::MODE_REQUEST,
        'simplekeys' => true,
    ],
];
