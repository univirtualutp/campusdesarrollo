<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace tool_moodlenet\local;

use tool_moodlenet\local\remote_resource;
use tool_moodlenet\local\url;

/**
 * Class tool_moodlenet_remote_resource_testcase, providing test cases for the remote_resource class.
 *
 * @package    tool_moodlenet
 * @category   test
 * @copyright  2020 Jake Dallimore <jrhdallimore@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class remote_resource_test extends \advanced_testcase {

    /**
     * Test getters.
     *
     * @dataProvider remote_resource_data_provider
     * @param string $url the url of the resource.
     * @param string $metadata the resource metadata like name, description, etc.
     * @param string $expectedextension the extension we expect to find when querying the remote resource.
     */
    public function test_getters($url, $metadata, $expectedextension) {
        $this->resetAfterTest();

        $remoteres = new remote_resource(new \curl(), new url($url), $metadata);

        $this->assertEquals(new url($url), $remoteres->get_url());
        $this->assertEquals($metadata->name, $remoteres->get_name());
        $this->assertEquals($metadata->description, $remoteres->get_description());
        $this->assertEquals($expectedextension, $remoteres->get_extension());
    }

    /**
     * Data provider generating remote urls.
     *
     * @return array
     */
    public static function remote_resource_data_provider(): array {
        return [
            'With filename and extension' => [
                self::getExternalTestFileUrl('/test.html'),
                (object) [
                    'name' => 'Test html file',
                    'description' => 'Full description of the html file'
                ],
                'html'
            ],
            'With filename only' => [
                'http://example.com/path/file',
                (object) [
                    'name' => 'Test html file',
                    'description' => 'Full description of the html file'
                ],
                ''
            ]
        ];
    }

    /**
     * Test confirming the network based operations of a remote_resource.
     */
    public function test_network_features(): void {
        $url = self::getExternalTestFileUrl('/test.html');
        $nonexistenturl = self::getExternalTestFileUrl('/test.htmlzz');

        $remoteres = new remote_resource(
            new \curl(),
            new url($url),
            (object) [
                'name' => 'Test html file',
                'description' => 'Some description'
            ]
        );
        $nonexistentremoteres = new remote_resource(
            new \curl(),
            new url($nonexistenturl),
            (object) [
                'name' => 'Test html file',
                'description' => 'Some description'
            ]
        );

        // We need to handle size of -1 (missing "Content-Length" header), or where it is set and greater than zero.
        $this->assertThat(
            $remoteres->get_download_size(),
            $this->logicalOr(
                $this->equalTo(-1),
                $this->greaterThan(0),
            ),
        );

        [$path, $name] = $remoteres->download_to_requestdir();
        $this->assertIsString($path);
        $this->assertEquals('test.html', $name);
        $this->assertFileExists($path . '/' . $name);

        $this->expectException(\coding_exception::class);
        $nonexistentremoteres->get_download_size();
    }
}
