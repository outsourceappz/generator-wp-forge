<?php

namespace <%- props.appName %>\Core;

class FileSystem
{

    public function requireOnce($file)
    {
        require_once $file;
    }

    public function glob($pattern, $flags = 0)
    {
        return glob($pattern, $flags);
    }

    public function files($directory)
    {
        $glob = glob($directory.'/*');
        if ($glob === false) {
            return [];
        }
        // To get the appropriate files, we'll simply glob the directory and filter
        // out any "files" that are not truly files so we do not end up with any
        // directories in our list, but only true files within the directory.
        return array_filter($glob, function ($file) {
            return filetype($file) == 'file';
        });
    }
}
