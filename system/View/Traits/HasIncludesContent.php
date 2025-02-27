<?php

namespace System\View\Traits;

trait HasIncludesContent
{

    private function checkIncludesContent()
    {
        while (1) {
            $includes = $this->findIncludes();
            if (!empty($includes)) {
                foreach ($includes as $include) {
                    $this->initialIncludes($include);
                }
            } else {
                break;
            }
        }

    }

    private function initialIncludes($include)
    {
        $find_include = htmlspecialchars_decode("@include('" . $include . "')");
        $this->content = str_replace($find_include, $this->viewLoader($include), htmlspecialchars_decode($this->content));

    }

    private function findIncludes()
    {
        $includes = [];
        preg_match_all("/@include+\(([^)]+)\)/", $this->content, $includes);
        if (isset($includes[1])) {
            foreach ($includes[1] as $include) {
                $new_includes = [];
                foreach ($includes[1] as $include) {
                    $include = str_replace("'", "", htmlspecialchars_decode($include));
                    array_push($new_includes, $include);
                }
                return $new_includes;
            }
        }
        return false;
    }


}
