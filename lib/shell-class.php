<?php
class Shell {

    private function output_green( $output ) {
        $output = trim( $output );
        return "\033[32m" . $output . "\033[0m";
    }

    private function output_red( $output ) {
        $output = trim( $output );
        return "\033[31m" . $output . "\033[0m";
    }

    public function do_shell_cmd( $cmd = '', $blocking = 0 ) {

        $cmd = escapeshellcmd( $cmd );

        $pipes = array();
        $descriptors = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w"),
        );
        $start = time();
        $process = proc_open($cmd, $descriptors, $pipes) or die("Can't open process $cmd!");

        stream_set_blocking($pipes[1], $blocking);
        stream_set_blocking($pipes[2], $blocking);

        $pipe_out_one = "";
        $pipe_out_two = "";

        $output = "";
        while (!feof($pipes[2])) {
            $read = array($pipes[2]);
            $other_read = array($pipes[1]);
            $write = NULL;
            $except = NULL;
            stream_select($read, $write, $except, 0);
            if ( time() - $start > 10 && empty($read) && empty($other_read) ) die( "\033[31mTIME OUT! -- Pipe 2.\033[0m" . PHP_EOL );
            if (!empty($read) ) {
                $output = fgets($pipes[2]);
                $pipe_out_two .= $output;
                # HERE PARSE $output TO UPDATE DOWNLOAD STATUS...
                echo $this->output_green( $output ) . PHP_EOL;
            }

        }

        $output = "";
        while (!feof($pipes[1])) {
            $read = array($pipes[1]);
            $other_read = array($pipes[2]);
            $write = NULL;
            $except = NULL;
            stream_select($read, $write, $except, 0);
            if ( time() - $start > 10 && empty($read) && empty($other_read) ) die( "\e[31mTIME OUT! -- Pipe 1.\e[0m" . PHP_EOL );
            if (!empty($read) && fgets($pipes[1]) != $output ) {
                $output = fgets($pipes[1]);
                $pipe_out_one .= $output;
                # HERE PARSE $output TO UPDATE DOWNLOAD STATUS...
                echo $this->output_green( $output ) . PHP_EOL;
            }
        }

        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $cmd_status = proc_close($process);

        if( $cmd_status != 0 ) {
            echo $this->output_red( "Exited with error: " . $cmd_status ) . PHP_EOL;
        } else {
            echo $this->output_green( "Done!" ) . PHP_EOL;
        }

        return array(
            "cmd_status" => $cmd_status,
            "out" => trim( $pipe_out_one ),
            "ex_out" => trim( $pipe_out_two ),
        );
    }
}
