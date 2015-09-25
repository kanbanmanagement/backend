<?php

namespace Slimvc;

/**
 * Translator class
 */
class Translator
{
    private $locale = 'pl';
    private $localeExists = ['pl','en'];
    private $resource = [];

    public function __construct($locale = 'pl')
    {
        $this->locale = in_array($locale, $this->localeExists) ? $locale : 'pl';
        $this->getFromResource(APP_PATH."/../app/Translate/{$this->locale}.lang");
        return $this;
    }

    public function setLocale($locale = 'pl')
    {
        $this->locale = $locale;
        return $this;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function addResource(array $resource)
    {
        foreach ($resource as $key => $value) {
            $this->resource[$key] = $value;
        }
        return $this;
    }

    public function translate($data)
    {
        return array_key_exists($data, $this->resource) ? $this->resource[$data] : $data;
    }

    private function getFromResource($file)
    {
        if (file_exists($file)) {
              $this->resource = parse_ini_file($file);
              return true;
        }
        return false;
    }
}
