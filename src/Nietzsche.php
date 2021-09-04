<?php
/* This file is part of Nietzsche | SSITU | (c) 2021 I-is-as-I-does */
namespace SSITU\Nietzsche;

use \SSITU\Blueprints\Log;

class Nietzsche implements Log\FlexLogsInterface

{
    use Log\FlexLogsTrait;

    public function perfectMustache($primaryViewPath, $variables, $mustacheOpts = [], $requiredNonEmpty = [])
    {
        $this->logs = [];

        if (!$this->isInvalidPath($primaryViewPath)) {

            if (is_object($variables)) {
                $variables = Trades\Converter::objToArr($variables);
            }

            if (!$this->hasMissingContent($variables, $requiredNonEmpty)) {
               
                $viewDir = dirname($primaryViewPath);
                $viewName = basename($primaryViewPath);

                try {
                    $mustacheOpts['loader'] = new \Mustache_Loader_FilesystemLoader($viewDir);
                    $mustache = new \Mustache_Engine($mustacheOpts);
                    $render = $mustache->render($viewName, new Trades\Warden($variables));
                } catch (\Exception$e) {
                    $this->logs['exception'] = $e->getMessage();
                }
                if (!empty($render)) {
                    return $render;
                }
            }
        }
       
        return false;
    }

    private function isInvalidPath($primaryViewPath)
    {
        if (empty($primaryViewPath) || !file_exists($primaryViewPath)) {
            $this->logs['invalid-view-path'] = $primaryViewPath;
            return true;
        }
        return false;
    }

    private function hasMissingContent($variables, $requiredNonEmpty)
    {
        if (empty($variables)) {
            $missing = $requiredNonEmpty;
        } else {
            $missing = [];
            foreach ($requiredNonEmpty as $vk) {
                if (!array_key_exists($vk, $variables)) {
                    $missing[] = $vk;
                }
            }
            if (!empty($missing)) {
                $this->logs['missing'] = $missing;
                return true;
            }
        }
        return false;
    }

}
