<?php

namespace Tools\UTF8;

use Tools\File\{ File, Folder };

class UTF8
{

	public static function sanitize(File $file) : void
	{
        // Folder
        if ($file->isFolder()) {
            $file = new Folder($file->getPath());
            foreach ($file->read() as $_file) {
                static::sanitize($_file);
            }
            return;
        }

        // File
        $fileContents = $file->read();

        // Sanitize
        foreach (static::getUTF8ToASCII() as $k => $v) {
            $fileContents = str_replace($k, $v, $fileContents);
        }

        // Save
        $file->setContent($fileContents)->save();
    }

	public static function getUTF8ToASCII() : array
	{
        return [
            chr(0xC2) . chr(0xA0)    => ' '     // Espace insécable
        ];
    }

}