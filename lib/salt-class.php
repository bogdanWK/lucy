<?php
class Salt {

    public function exec_salt_cmd( $run_cmd ) {
        $shell = new Shell();
        $cmd = "salt 'opendev' cmd.run '" . $run_cmd . "' --out=json";
        $result = $shell->do_shell_cmd( $cmd );
        return $result;
    }
}