<?php

class view {

    private $file;
    private $extension = 0;
    private $temp_cache= "theme/cache/";
    private $temp_path = "theme/views/";

    /* Undeclared variable array */
    public $vars = array();

    public function __construct($template = NULL) {
        if (!empty($template)) {
            $this->setFile($template);
        }
        return $this;
    }

    //Get all undeclared variables
    public function getVars() {
        return $this->vars;
    }

    // Get the class in an undeclared variable 
    public function &__get($key) {
        if (array_key_exists($key, $this->vars)) {
            return $this->vars[$key];
        }
    }

    // Setting the class does not declare a variable
    public function __set($key, $val) {
        $this->vars[$key] = $val;
    }

    public function setAttr($key, $val) {
        $this->__set($key, $val);
    }

    // Setting the template path
    public function setPath($path) {
        $this->temp_path = $path;
        return $this;
    }

    // Set the cache time in minutes
    public function setExtens($time) {
        $this->extension = $time * 60;
        return $this;
    }
    
    //Set the cache path
    public function setCache($path) {
        if (is_dir($path)) {
            $this->temp_cache = $path;
        } else {
            show_error("Fatal Error", "Template cache path that you set not found!" . $path);
        }
        return $this;
    }

    // Change
    private function compile($file) {
        $filestr = '';

        require_once 'Cache.php';
        $temp_cache = new Cache(array(
            'cache_name' => md5($file),
            'cache_path' => $this->temp_cache,
            'cache_extension' => $this->extension * 60
        ));

        if ($temp_cache->cached("html")) {
            $filestr = $temp_cache->get("html");
        } else {
            $keys = array(
                '{if %%}' => '<?php if (\1): ?>',
                '{elseif %%}' => '<?php ; elseif (\1): ?>',
                '{for %%}' => '<?php for (\1): ?>',
                '{foreach %%}' => '<?php foreach (\1): ?>',
                '{while %%}' => '<?php while (\1): ?>',
                '{/if}' => '<?php endif; ?>',
                '{/for}' => '<?php endfor; ?>',
                '{/foreach}' => '<?php endforeach; ?>',
                '{/while}' => '<?php endwhile; ?>',
                '{else}' => '<?php ; else: ?>',
                '{continue}' => '<?php continue; ?>',
                '{break}' => '<?php break; ?>',
                '{$%% = %%}' => '<?php $\1 = \2; ?>',
                '{$%%++}' => '<?php $\1++; ?>',
                '{$%%--}' => '<?php $\1--; ?>',
                '{$%%}' => '<?php echo $\1; ?>',
                '{comment}' => '<?php /*',
                '{/comment}' => '*/ ?>',
                '{/*}' => '<?php /*',
                '{*/}' => '*/ ?>',
            );

            foreach ($keys as $key => $val) {
                $patterns[] = '#' . str_replace('%%', '(.+)', preg_quote($key, '#')) . '#U';
                $replace[] = $val;
            }
            $filestr = preg_replace($patterns, $replace, file_get_contents($file));
            $temp_cache->set("html", $filestr);
        }
        return $filestr;
    }

    // Set contents of the file to be displayed
    public function display($template) {
        if (is_file($this->temp_path . $template)) {
            $this->file[] = $this->temp_path . $template;
        } else {
            show_error("Fatal Error", "Template File Not Found!" . $this->temp_path . $template);
        }
        return $this;
    }

    // Output Template file
    public function render() {
        $template = '';

        foreach ($this->file as $file) {
            $template .= $this->compile($file);
        }

        return $this->evaluate($template, $this->getVars());
    }

    // Convert php
    private function evaluate($code, array $variables = NULL) {
        if ($variables != NULL) {
            extract($variables);
        }
        return eval('?>' . $code);
    }

}