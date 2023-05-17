<?php
if (empty($blocks_file)) {
  header("HTTP/1.1 404 Not Found");
  exit();
}

class Blocks
{
  private $dir;
  private $configFileName = 'config.php';
  private $configFilePath;
  private $configFileTime;
  private $properties = [];

  public function __construct()
  {
    $this->configFileTime = 24 * 60 * 60 * 30;
    $this->dir = dirname(__FILE__);
    $this->configFilePath = $this->dir . '/' . $this->configFileName;
    $this->setProperties();
    if (!$this->properties
      || !file_exists($this->configFilePath)
      || time() - filemtime($this->configFilePath) > $this->configFileTime
    ) {
      $this->updateConfigFile();
      $this->setProperties();
    }
  }

  private function updateConfigFile()
  {
    $current_dir = getcwd();
    $path = '.' . str_replace($current_dir, '', $this->dir);
    $dir = $this->readDir($this->dir);
    if ($dir && is_array($dir) && isset($dir['dirs']) && is_array($dir['dirs'])) {
      foreach ($dir['dirs'] as $dirName => $dirContent) {
        $files = $dirContent['files'] ?? [];
        $m = count($files);
        if ($m > 0) {
          $m -= 1;
        }
        $n = rand(0, $m);
        $file = $files[$n] ?? '';
        $this->properties[$dirName] = $path . '/' . $dirName . '/' . $file;
      }
    }
    @file_put_contents($this->configFilePath, '<?php $properties = ' . var_export($this->properties, true) . ';');
  }

  private function readDir($dirPath)
  {
    $dir = ['dirs' => [], 'files' => []];
    if (is_dir($dirPath)) {
      if ($dh = opendir($dirPath)) {
        while (($e = readdir($dh)) !== false) {
          if (($e == ".") || ($e == "..")) {
            continue;
          }
          $filePath = $dirPath . '/' . $e;
          if (is_dir($filePath)) {
            $dir['dirs'][$e] = $this->readDir($filePath);
          } elseif (is_file($filePath)) {
            $dir['files'][] = $e;
          }
        }
        closedir($dh);
      }
    }
    return $dir;
  }

  private function setProperties()
  {
    if (file_exists($this->configFilePath)) {
      include_once($this->configFilePath);
      if (!empty($properties) && is_array($properties)) {
        $this->properties = $properties;
      }
    }
  }

  public function __get($property) {
    return $this->properties[$property] ?? '';
  }

}

$blocks = new Blocks();
return $blocks;
