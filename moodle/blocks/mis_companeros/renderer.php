<?php
class block_mis_companeros_renderer extends plugin_renderer_base {

    public function render_companions_list($students) {
        $output = '';
        $output .= '<form method="post">';
        $output .= '<table class="companion-list">';
        
        foreach ($students as $student) {
            $output .= '<tr>';
            $output .= '<td><img src="' . $student->profileimageurl . '" alt="' . $student->name . '"></td>';
            $output .= '<td>' . $student->name . '</td>';
            $output .= '<td>' . $student->email . '</td>';
            $output .= '<td><input type="checkbox" name="selected[]" value="' . $student->id . '"></td>';
            $output .= '</tr>';
        }

        $output .= '</table>';
        $output .= '<textarea name="message" placeholder="' . get_string('sendmessage', 'block_mis_companeros') . '"></textarea>';
        $output .= '<br><input type="submit" value="' . get_string('sendmessage', 'block_mis_companeros') . '">';
        $output .= '</form>';
        return $output;
    }
}
