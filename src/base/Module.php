<?php
/**
 * @copyright Copyright (c) 2016 Roman Ishchenko
 * @license https://github.com/ischenko/yii2-jsloader/blob/master/LICENSE
 * @link https://github.com/ischenko/yii2-jsloader#readme
 */

namespace ischenko\yii2\jsloader\base;

use yii\base\InvalidParamException;
use ischenko\yii2\jsloader\ModuleInterface;

/**
 * Base implementation of module
 *
 * @author Roman Ishchenko <roman@ishchenko.ck.ua>
 * @since 1.0
 */
class Module extends \yii\base\Object implements ModuleInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var array
     */
    private $files = [];

    /**
     * @var array
     */
    private $dependencies = [];

    /**
     * @var string alias name
     */
    private $alias;

    /**
     * Module constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct([]);

        if (empty($name) || !is_string($name)) {
            throw new InvalidParamException('Name must be a string and cannot be empty');
        }

        $this->name = $name;
    }

    /**
     * @return string a name associated with a module
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets alias name for a module
     *
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        if (!is_string($alias)) {
            throw new InvalidParamException('Alias must be a string');
        }

        $this->alias = $alias;

        return $this;
    }

    /**
     * @return string an alias for a module or name (see [[getName()]]) if alias not set
     */
    public function getAlias()
    {
        if (!$this->alias) {
            return $this->getName();
        }

        return $this->alias;
    }

    /**
     * Adds JS file into a module
     *
     * @param string $file URL of a file
     * @param array $options options for given file
     *
     * @return $this
     * @throws InvalidParamException
     */
    public function addFile($file, $options = [])
    {
        if (empty($file) || !is_string($file)) {
            throw new InvalidParamException('Filename must be a string and cannot be empty');
        } elseif (!is_array($options)) {
            throw new InvalidParamException('Options value must be an array');
        }

        $this->files[$file] = $options;

        return $this;
    }

    /**
     * @return array a list of files and their options, indexed by filename
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Clears all files from a module
     *
     * @return $this
     */
    public function clearFiles()
    {
        $this->files = [];

        return $this;
    }

    /**
     * Adds dependency to a module
     *
     * @param ModuleInterface $depends an instance of another module which will is being added as dependency
     *
     * @return $this
     */
    public function addDependency(ModuleInterface $depends)
    {
        if ($depends->getFiles() === []) {
            foreach ($depends->getDependencies() as $dependency) {
                $this->addDependency($dependency);
            }

            return $this;
        }

        $this->dependencies[$depends->getName()] = $depends;

        return $this;
    }

    /**
     * @return ModuleInterface[] a list of dependencies of a module
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * Clears all dependencies from a module
     *
     * @return $this
     */
    public function clearDependencies()
    {
        $this->dependencies = [];

        return $this;
    }

    /**
     * @param array $options options for a module
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array a list of assigned options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string base URL for a module
     */
    public function getBaseUrl()
    {
        return isset($this->options['baseUrl'])
            ? $this->options['baseUrl'] : '';
    }
}
