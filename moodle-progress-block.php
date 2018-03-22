/*

  This is the code that powers the EOQ countdown on the Moodle Home page.
    I have Babli plugging this in to the EOQ block code.
    I am not 100% that this is exactly what is on the site live so check with her.

*/

class block_student_progress extends block_base {

  function init() {
    $this->title = get_string('pluginname', 'block_student_progress');
  }

  public function get_content() {
    global $USER, $CFG;

    require_once $CFG->dirroot."/oraint/wcc_functions.php";

    if ($this->content !== NULL) {
      return $this->content;
    }
    if (!$CFG->oci_disabled){
      // if there is not result from OCI call then block becomes invisible
      if (!$progress = call_OCI_request_progress($USER->username)) {
        return $this->content;
      }
    }


    $this->content = new stdClass;
    $this->content->text = "<font size=\"-1\"><table cellpadding=4>";
    $this->content->text .= '<tr><td><b>'.$USER->firstname.' '.$USER->lastname.'</b></td><td></td></tr>';
  function init() {
    $this->title = get_string('pluginname', 'block_student_progress');
  }

  public function get_content() {
    global $USER, $CFG;

    require_once $CFG->dirroot."/oraint/wcc_functions.php";

    if ($this->content !== NULL) {
      return $this->content;
    }
    if (!$CFG->oci_disabled){
      // if there is not result from OCI call then block becomes invisible
      if (!$progress = call_OCI_request_progress($USER->username)) {
        return $this->content;
      }
    }


    $this->content = new stdClass;
    $this->content->text = "<font size=\"-1\"><table cellpadding=4>";
    $this->content->text .= '<tr><td><b>'.$USER->firstname.' '.$USER->lastname.'</b></td><td></td></tr>';
    $this->content->text .= '<tr><td>Requirement for end of current Quarter:</td><td>'.$progress['req_eoq'].'</td></tr>';
    $this->content->text .= '<tr><td>Total Submissions to Date:</td><td>'.$progress['total_subs'].'</td></tr>';
    $this->content->text .= '<tr><td>Total Program Requirement:</td><td>'.$progress['total_req'].'</td></tr>';

    //$this->content = new stdClass;
    //$this->content->text = "<font size=\"-1\"><table cellpadding=4>";
    //$this->content->text .= '<tr><td><b>'.$USER->firstname.' '.$USER->lastname.'</b></td><td></td></tr>';
    //$this->content->text .= '<tr><td>Total Program Requirement:</td><td>'.$progress['total_req'].'</td></tr>';
    //$this->content->text .= '<tr><td>Requirement for end of current Quarter:</td><td>'.$progress['req_eoq'].'</td></tr>';
    //$this->content->text .= '<tr><td>Total Submissions to Date:</td><td>'.$progress['total_subs'].'</td></tr>';


    $this->content->text .= '</table></font>
<div>
<span id="output"></span>
</div>
<script>
    var date_diff_indays = function(date1, date2) {
    var dt1 = new Date(date1);
    var dt2 = new Date(date2);
    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
    };
    var eoqDates = ["03/31/", "06/30/", "09/30/", "12/31/"];
    var currentYear = new Date().getFullYear();
    var datePicker;

    if (new Date() < new Date(eoqDates[0] + currentYear)) {
        datePicker = 0;
    }
    else if (new Date() < new Date(eoqDates[1] + currentYear)) {
        datePicker = 1;
    }
    else if (new Date() < new Date(eoqDates[2] + currentYear)) {
        datePicker = 2;
    }
    else {
        datePicker = 3;
    }
    document.getElementById("output").innerHTML = "<strong style=&apos;color: red; font-size: 1em;&apos;>The end of the current quarter is " + (eoqDates[datePicker]+currentYear) + " at Midnight (Eastern time)</strong>.<br> Less than " + (date_diff_indays(new Date(), (eoqDates[datePicker]+currentYear))) + " day(s) to meet your submission requirment. Plan ahead to stay current!";
</script>
</div> 
';


    return $this->content;
  }

}