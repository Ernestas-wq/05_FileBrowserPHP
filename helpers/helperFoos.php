<?php
function defineBaseDir($path, $level)
{
    $path = getcwd();
    $sep = DIRECTORY_SEPARATOR;
    $tmp = explode($sep, $path);
    # Making base directory one level up
    $remove_last = array_splice($tmp, count($tmp) - $level);
    // $base_dir = implode($sep, $tmp);
    return implode($sep, $tmp);
};
