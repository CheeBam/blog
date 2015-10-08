<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 04.10.15
 * Time: 18:14
 */

namespace Framework;

class Location
{
    /**
     * Array of words.
     *
     * @var array $vars Translated words.
     */
    public $vars = [];

    /**
     * Search path to file with translating words. Parse founded ini file.
     *
     * @param string $loc Preferable location.
     */
    public function __construct($loc = 'en')
    {
        $path = ROOT.'app/location/'.$loc.'-'.strtoupper($loc).'.ini';
        file_exists($path)?
            $this->vars = parse_ini_file($path):$this->vars = parse_ini_file(ROOT.'app/location/en-EN.ini');
    }

    /**
     * Returns translated words.
     *
     * @return array Translated words.
     */
    public function getWord($word)
    {
        return array_key_exists($word, $this->vars)?$this->vars[$word]:$word;
    }

}