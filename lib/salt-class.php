<?php
class Salt {

    public function exec_salt_cmd( $run_cmd ) {
        $shell = new Shell();
        $cmd = "salt 'opendev' cmd.run '" . $run_cmd . "' --out=json";
        $result = $shell->do_shell_cmd( $cmd );
        return $result;
    }

    public function restart() {
        $shell = new Shell();
        $cmd = "/etc/init.d/salt-master restart && /etc/init.d/salt-minion restart 2>&1";
        $result = $shell->do_shell_cmd( $cmd, 1 );
        return $result;
    }

    public function start() {
        $shell = new Shell();
        $cmd = "/etc/init.d/salt-master start && /etc/init.d/salt-minion start";
        $result = $shell->do_shell_cmd( $cmd, 1 );
        return $result;
    }

    public function stop() {
        $shell = new Shell();
        $cmd = "/etc/init.d/salt-master stop && /etc/init.d/salt-minion stop";
        $result = $shell->do_shell_cmd( $cmd, 1 );
        return $result;
    }
}