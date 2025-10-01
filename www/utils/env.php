<?php

function get_env_variable($variable_name) {
    $env = getenv($variable_name);
    if ($env === false) {
        throw new Exception("Environment variable $variable_name is not set");
    }
    return $env;
}

?>