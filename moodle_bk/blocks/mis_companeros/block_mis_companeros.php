<?php
class block_mis_companeros extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_mis_companeros');
    }

    public function get_content() {
        global $OUTPUT, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        
        // Enlace a la vista de compañeros
        $url = new moodle_url('/blocks/mis_companeros/view.php', ['courseid' => $this->page->course->id]);
        $this->content->text = $OUTPUT->single_button($url, get_string('viewcompanions', 'block_mis_companeros'), 'get');
        
        return $this->content;
    }

    public function has_config() {
        return false;
    }
}
