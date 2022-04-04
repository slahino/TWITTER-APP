<?php
namespace mf\utils;

class ClassLoader extends AbstractClassLoader {
    
    protected function getFilename(string $classname): string {
        $path = str_replace("\\", DIRECTORY_SEPARATOR, $classname);
        $path = $path . ".php";
        return $path;
    }
    
    protected function makePath(string $filename): string {
        $path = $this->prefix . DIRECTORY_SEPARATOR . $filename;
        return $path;
    }
    
    public function loadClass(string $classname) {
        $filename = $this->getFilename($classname);
        $path = $this->makePath($filename);

        if (file_exists($path)) {
            require_once $path;
        }
    }
}

