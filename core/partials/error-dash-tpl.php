<?php

if( ! isset( $total_exec_class ) ) {
    $total_exec_class = 'danger';
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

$error_class = 'pass';
if( $error_count_notice > 0 ) {
    $error_class = 'info';
}
if( $error_count_warning > 0 || $error_count_strict > 0 || $error_count_deprecated > 0 ) {
    $error_class = 'warning';
}
if( $error_count_fatal > 0 ) {
    $error_class = 'danger';
}

?>
<div id="lucy-error-dashboard">
    <input type="checkbox" id="panel-toggle" onclick="toggleActive();" />
    <label id="chevron-toggle" for="panel-toggle"><i class="material-icons"></i></label>
    <span class="status">
        <span class="label"><b>Errors: </b></span>
        <span class="value <?php echo $error_class; ?>" ><?php echo $error_count; ?> </span>
    </span>
    <span class="execution">
        <span class="label"><b>Total Execution: </b></span>
        <span class="value <?php echo $total_exec_class; ?>"><?php echo $time_exec; ?></span>
    </span>
    <div class="lucy-error-stack">
        <?php
        if( isset( $this->errors ) && ! empty( $this->errors ) ) {
            if( isset( $this->errors['Fatal'] ) ) {
                foreach ( $this->errors['Fatal'] as $error ) {
                    echo '<div class="row fatal">
                                <span class="error"> <i class="material-icons">&#xE000;</i> ' . $error['error'] . '</span>
                                <span class="code"> [' . $error['code'] . ']:</span>
                                <span class="desc">' . $error['description'] . '</span>
                                <div class="details">
                                    in file: <span class="file">' . $error['file'] . '</span>
                                    at line: <span class="line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
            if( isset( $this->errors['Warning'] ) ) {
                foreach ( $this->errors['Warning'] as $error ) {
                    echo '<div class="row warning">
                                <span class="error"> <i class="material-icons">&#xE002;</i> ' . $error['error'] . '</span>
                                <span class="code"> [' . $error['code'] . ']:</span>
                                <span class="desc">' . $error['description'] . '</span>
                                <div class="details">
                                    in file: <span class="file">' . $error['file'] . '</span>
                                    at line: <span class="line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
            if( isset( $this->errors['Notice'] ) ) {
                foreach ( $this->errors['Notice'] as $error ) {
                    echo '<div class="row notice">
                                <span class="error"> <i class="material-icons">&#xE88E;</i> ' . $error['error'] . '</span>
                                <span class="code"> [' . $error['code'] . ']:</span>
                                <span class="desc">' . $error['description'] . '</span>
                                <div class="details">
                                    in file: <span class="file">' . $error['file'] . '</span>
                                    at line: <span class="line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
            if( isset( $this->errors['Strict'] ) ) {
                foreach ( $this->errors['Strict'] as $error ) {
                    echo '<div class="row strict">
                                <span class="error"> <i class="material-icons">&#xE002;</i> ' . $error['error'] . '</span>
                                <span class="code"> [' . $error['code'] . ']:</span>
                                <span class="desc">' . $error['description'] . '</span>
                                <div class="details">
                                    in file: <span class="file">' . $error['file'] . '</span>
                                    at line: <span class="line">' . $error['line'] . '</span>
                                </div>
                          </div>';
                }
            }
            if( isset( $this->errors['Deprecated'] ) ) {
                foreach ( $this->errors['Deprecated'] as $error ) {
                    echo '<div class="row deprecated">
                                <span class="error"> <i class="material-icons">&#xE002;</i> ' . $error['error'] . '</span>
                                <span class="code"> [' . $error['code'] . ']:</span>
                                <span class="desc">' . $error['description'] . '</span>
                                <div class="details">
                                    in file: <span class="file">' . $error['file'] . '</span>
                                    at line: <span class="line">' . $error['line'] . '</span>
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
        if ( document.getElementById("panel-toggle").checked ) {
            document.getElementById("lucy-error-dashboard").classList.add("active");
            document.getElementById("chevron-toggle").classList.add("active");
        } else {
            document.getElementById("lucy-error-dashboard").classList.remove("active");
            document.getElementById("chevron-toggle").classList.remove("active");
        }
    }
</script>
<link rel="stylesheet" type="text/css" href="core/assets/css/error-handler.css">
