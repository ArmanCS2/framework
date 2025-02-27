<?php


namespace System\Request\Traits;


trait HasFileValidationRules
{
    public function fileValidation($attribute, $rules)
    {
        foreach ($rules as $rule) {
            if ($rule == 'required') {
                $this->fileRequired($attribute);
            } elseif (strpos($rule, 'mimes:') === 0) {
                $rule = str_replace('mimes:', '', $rule);
                $rule = explode(',', $rule);
                $this->fileType($attribute, $rule);
            } elseif (strpos($rule, 'max:') === 0) {
                $rule = str_replace('max:', '', $rule);
                $this->maxfile($attribute, $rule);
            } elseif (strpos($rule, 'min:') === 0) {
                $rule = str_replace('min:', '', $rule);
                $this->minfile($attribute, $rule);
            }
        }
    }

    protected function fileRequired($attribute)
    {
        if (empty($this->files[$attribute]['name']) && $this->checkFirstError($attribute)) {
            $this->setError($attribute, "$attribute is required");
        }
    }

    protected function fileType($attribute,$types){
        if ($this->checkFileExists($attribute) && $this->checkFirstError($attribute)) {
            $currentFileType=explode('/',$this->files[$attribute]['type'])[1];
            if (!in_array($currentFileType,$types)) {
                $this->setError($attribute, "$attribute allowed types are " . implode(',',$types));
            }
        }
    }

    protected function maxfile($attribute, $size)
    {
        if ($this->checkFileExists($attribute) && $this->checkFirstError($attribute)) {
            $size = $size * 1024;
            if ($this->files[$attribute]['size'] > $size) {
                $this->setError($attribute, "$attribute max size for files is" . ($size / 1024));
            }
        }
    }

    protected function minfile($attribute, $size)
    {
        if ($this->checkFileExists($attribute) && $this->checkFirstError($attribute)) {
            $size = $size * 1024;
            if ($this->files[$attribute]['size'] < $size) {
                $this->setError($attribute, "$attribute min size for files is" . ($size / 1024));
            }
        }
    }


}