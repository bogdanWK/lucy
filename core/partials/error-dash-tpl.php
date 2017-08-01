<?php

if( ! isset( $total_exec_class ) ) {
    $total_exec_class = 'lucy-danger';
}

if( ! isset( $time_exec ) ) {
    $time_exec = number_format(0, 2) . 's';
}

$error_count_fatal = 0;
$error_count_warning = 0;
$error_count_notice = 0;
$error_count_strict = 0;
$error_count_deprecated = 0;

if( isset( $this->errors['Fatal'] ) ) {
    $error_count_fatal = count($this->errors['Fatal']);
}
if( isset( $this->errors['Warning'] ) ) {
    $error_count_warning = count( $this->errors['Warning'] );
}
if( isset( $this->errors['Notice'] ) ) {
    $error_count_notice = count( $this->errors['Notice'] );
}
if( isset( $this->errors['Strict'] ) ) {
    $error_count_strict = count( $this->errors['Strict'] );
}
if( isset( $this->errors['Deprecated'] ) ) {
    $error_count_deprecated = count( $this->errors['Deprecated'] );
}

$error_count = $error_count_fatal + $error_count_warning + $error_count_notice + $error_count_strict + $error_count_deprecated;

$error_class = 'lucy-pass';
if( $error_count_notice > 0 ) {
    $error_class = 'lucy-info';
}
if( $error_count_warning > 0 || $error_count_strict > 0 || $error_count_deprecated > 0 ) {
    $error_class = 'lucy-warning';
}
if( $error_count_fatal > 0 ) {
    $error_class = 'lucy-danger';
}

?>
<div id="lucy-error-dashboard">
    <input type="checkbox" id="lucy-panel-toggle" onclick="toggleActive();" />
    <label id="chevron-toggle" for="lucy-panel-toggle"><i class="material-icons"></i></label>
    <span class="lucy-status">
        <span class="lucy-label"><b>Errors: </b></span>
        <span class="lucy-value <?php echo $error_class; ?>" ><?php echo $error_count; ?> </span>
    </span>
    <span id="lucy-title">lucy</span>
    <span class="lucy-execution">
        <span class="lucy-label"><b>Total Execution: </b></span>
        <span class="lucy-value <?php echo $total_exec_class; ?>"><?php echo $time_exec; ?></span>
    </span>
    <div class="lucy-error-stack">
        <?php
        if( isset( $this->errors ) && ! empty( $this->errors ) ) {
            if( isset( $this->errors['Fatal'] ) ) {
                foreach ( $this->errors['Fatal'] as $error ) {
                    echo '<div class="lucy-row lucy-fatal">
                                <span class="lucy-error"> <i class="material-icons">&#xE000;</i> ' . $error['error'] . '</span>
                                <span class="lucy-code"> [' . $error['code'] . ']:</span>
                                <span class="lucy-desc">' . $error['description'] . '</span>
                                <div class="lucy-details">
                                    in file: <span class="lucy-file">' . $error['file'] . '</span>
                                    at line: <span class="lucy-line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
            if( isset( $this->errors['Warning'] ) ) {
                foreach ( $this->errors['Warning'] as $error ) {
                    echo '<div class="lucy-row lucy-warning">
                                <span class="lucy-error"> <i class="material-icons">&#xE002;</i> ' . $error['error'] . '</span>
                                <span class="lucy-code"> [' . $error['code'] . ']:</span>
                                <span class="lucy-desc">' . $error['description'] . '</span>
                                <div class="lucy-details">
                                    in file: <span class="lucy-file">' . $error['file'] . '</span>
                                    at line: <span class="lucy-line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
            if( isset( $this->errors['Notice'] ) ) {
                foreach ( $this->errors['Notice'] as $error ) {
                    echo '<div class="lucy-row lucy-notice">
                                <span class="lucy-error"> <i class="material-icons">&#xE88E;</i> ' . $error['error'] . '</span>
                                <span class="lucy-code"> [' . $error['code'] . ']:</span>
                                <span class="lucy-desc">' . $error['description'] . '</span>
                                <div class="lucy-details">
                                    in file: <span class="lucy-file">' . $error['file'] . '</span>
                                    at line: <span class="lucy-line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
            if( isset( $this->errors['Strict'] ) ) {
                foreach ( $this->errors['Strict'] as $error ) {
                    echo '<div class="lucy-row lucy-strict">
                                <span class="lucy-error"> <i class="material-icons">&#xE002;</i> ' . $error['error'] . '</span>
                                <span class="lucy-code"> [' . $error['code'] . ']:</span>
                                <span class="lucy-desc">' . $error['description'] . '</span>
                                <div class="lucy-details">
                                    in file: <span class="lucy-file">' . $error['file'] . '</span>
                                    at line: <span class="lucy-line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
            if( isset( $this->errors['Deprecated'] ) ) {
                foreach ( $this->errors['Deprecated'] as $error ) {
                    echo '<div class="lucy-row lucy-deprecated">
                                <span class="lucy-error"> <i class="material-icons">&#xE002;</i> ' . $error['error'] . '</span>
                                <span class="lucy-code"> [' . $error['code'] . ']:</span>
                                <span class="lucy-desc">' . $error['description'] . '</span>
                                <div class="lucy-details">
                                    in file: <span class="lucy-file">' . $error['file'] . '</span>
                                    at line: <span class="lucy-line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    function toggleActive() {
        if ( document.getElementById("lucy-panel-toggle").checked ) {
            document.getElementById("lucy-error-dashboard").classList.add("active");
            document.getElementById("chevron-toggle").classList.add("active");
        } else {
            document.getElementById("lucy-error-dashboard").classList.remove("active");
            document.getElementById("chevron-toggle").classList.remove("active");
        }
    }
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->rel_path; ?>/assets/css/error-handler.css">
