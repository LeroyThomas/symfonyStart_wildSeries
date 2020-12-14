<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {
        $output = str_replace(" ", "-", "$input");

        // replace non letter or digits by -
        $output = preg_replace('~[^\pL\d]+~u', '-', $output);

        // remove unwanted characters
        $output = str_replace('à', 'a', $output);
        $output = str_replace('ç', 'c', $output);
        $output = str_replace('é', 'e', $output);
        $output = str_replace('è', 'e', $output);
        $output = str_replace('ù', 'u', $output);
        $output = str_replace('ê', 'e', $output);
        $output = str_replace('û', 'u', $output);
        $output = str_replace('â', 'a', $output);
        $output = str_replace('ô', 'o', $output);
        $output = str_replace('î', 'i', $output);
        $output = str_replace('ü', 'u', $output);
        $output = str_replace('ë', 'e', $output);
        $output = str_replace('ï', 'i', $output);

        // trim
        $output = trim($output, '-');

        // remove duplicate -
        $output = preg_replace('~-+~', '-', $output);

        // lowercase
        $output = strtolower($output);

        if (empty($output)) {
            return 'n-a';
        }
        return $output;
    }
}