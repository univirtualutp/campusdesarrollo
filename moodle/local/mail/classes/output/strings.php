<?php
/*
 * SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>
 *
 * SPDX-License-Identifier: GPL-3.0-or-later
 */

namespace local_mail\output;

class strings {
    /**
     * Returns a language string with parameters replaced.
     *
     * @param string $id The string identifier.
     * @param string|object|array $param A string, a number or an object to replace parameters with.
     * @return string The localized string.
     */
    public static function get(string $id, $param = null): string {
        return self::manager(current_language())->get_string($id, 'local_mail', $param);
    }

    /**
     * Returns all strings.
     *
     * @return string[] All localized strings.
     */
    public static function get_all(): array {
        $lang = current_language();

        return self::manager($lang)->load_component_strings('local_mail', $lang);
    }

    /**
     * Returns the identifiers of all strings.
     *
     * @return string[]
     */
    public static function get_ids(): array {
        return array_keys(self::manager('en')->load_component_strings('local_mail', 'en'));
    }

    /**
     * Returns multiple strings.
     *
     * @param string[] $ids Identifiers.
     * @return string[] Localized strings indexed by identifier.
     */
    public static function get_many(array $ids): array {
        return array_intersect_key(self::get_all(), array_combine($ids, $ids));
    }

    /**
     * String manager that ignores local_mail language packages from AMOS for Catalan and Spanish.
     *
     * @param string $lang Language.
     * @return \core_string_manager
     */
    private static function manager(string $lang): \core_string_manager {
        global $CFG;

        static $instance = null;

        if (!in_array($lang, ['ca', 'es', 'eu', 'gl'])) {
            return get_string_manager();
        }

        if ($instance != null && !PHPUNIT_TEST) {
            // @codeCoverageIgnoreStart
            return $instance;
            // @codeCoverageIgnoreEnd
        }

        $instance = new class ($CFG->langotherroot, $CFG->langlocalroot, []) extends \core_string_manager_standard {
            public function load_component_strings($component, $lang, $disablecache = false, $disablelocal = false) {
                global $CFG;

                if ($component != 'local_mail' || !in_array($lang, ['ca', 'es', 'eu', 'gl'])) {
                    // @codeCoverageIgnoreStart
                    throw new \coding_exception('Internal local_mail error: unexpected use of the string manager');
                    // @codeCoverageIgnoreEnd
                }

                // Use a different cache key than the standard string manager.
                $cachekey = $lang . '_' . $component . '_' . $this->get_key_suffix() . '_bundled';
                $cachedstring = $this->cache->get($cachekey);
                if (!$disablecache && !$disablelocal && $cachedstring !== false) {
                    return $cachedstring;
                }

                $string = [];

                // First load english pack.
                include("$CFG->dirroot/local/mail/lang/en/local_mail.php");

                // And then corresponding local english if present.
                if (!$disablelocal && file_exists("$CFG->langlocalroot/en_local/local_mail.php")) {
                    include("$CFG->langlocalroot/en_local/local_mail.php");
                }

                // Legacy location - used by contrib only.
                include("$CFG->dirroot/local/mail/lang/$lang/local_mail.php");

                // Local customisations.
                if (!$disablelocal && file_exists("$CFG->langlocalroot/{$lang}_local/local_mail.php")) {
                    include("$CFG->langlocalroot/{$lang}_local/local_mail.php");
                }

                // Save strings to cache.
                if (!$disablelocal && $cachedstring === false) {
                    $this->cache->set($cachekey, $string);
                }

                return $string;
            }
        };

        return $instance;
    }
}
