<?php

namespace System\View\Traits;

trait HasExtendsContent
{
    private $extendsContent;

    private function checkExtendsContent()
    {
        $layoutsFilePaths = $this->findExtends();
        if ($layoutsFilePaths) {
            $this->extendsContent = $this->viewLoader($layoutsFilePaths);
            $yields = $this->findYields();
            if ($yields) {
                foreach ($yields as $yield) {
                    $this->initialYields($yield);
                }

            }
            $this->content = $this->extendsContent;
        }

    }

    private function initialYields($yield)
    {
        $content = htmlspecialchars_decode($this->content);

        $startWord = htmlspecialchars_decode("@section('" . $yield . "')");
        $endWord = "@endsection";

        $startPos = strpos($content, $startWord);
        if ($startPos === false) {
            return $this->extendsContent = str_replace("@yield('" . $yield . "')", "", htmlspecialchars_decode($this->extendsContent));
        }
        $startPos += strlen($startWord);
        $endPos = strpos($content, $endWord, $startPos);
        if ($endPos === false) {
            return $this->extendsContent = str_replace("@yield('" . $yield . "')", "", htmlspecialchars_decode($this->extendsContent));
        }
        $length = $endPos - $startPos;
        $sectionContent = substr($content, $startPos, $length);

        return $this->extendsContent = str_replace("@yield('" . $yield . "')", htmlspecialchars_decode($sectionContent), htmlspecialchars_decode($this->extendsContent));

    }

    private function findExtends()
    {
        $filePathArray = [];
        $preg = "/s*@extends+\(([^)]+)\)/";
        preg_match($preg, $this->content, $filePathArray);
        $path = str_replace("'", "", htmlspecialchars_decode($filePathArray[1]));
        return isset($path) ? $path : false;
    }

    private function findYields()
    {
        $yields = [];
        preg_match_all("/@yield+\(([^)]+)\)/", $this->extendsContent, $yields, PREG_UNMATCHED_AS_NULL);
        if (isset($yields[1])) {
            $new_yields = [];
            foreach ($yields[1] as $yield) {
                $yield = str_replace("'", "", htmlspecialchars_decode($yield));
                array_push($new_yields, $yield);
            }
            return $new_yields;
        }
        return false;
    }
}