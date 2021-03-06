<?php
/**
 * @copyright Copyright (c) 2016 Roman Ishchenko
 * @license https://github.com/ischenko/yii2-jsloader/blob/master/LICENSE
 * @link https://github.com/ischenko/yii2-jsloader#readme
 */

namespace ischenko\yii2\jsloader;

/**
 * Interface for a module
 *
 * @author Roman Ishchenko <roman@ishchenko.ck.ua>
 * @since 1.0
 */
interface ModuleInterface
{
    /**
     * @return string a name associated with a module
     */
    public function getName();

    /**
     * Sets alias name for a module
     *
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias);

    /**
     * @return string an alias for a module or name (see [[getName()]]) if alias not set
     */
    public function getAlias();

    /**
     * @return string base URL for a module
     */
    public function getBaseUrl();

    /**
     * Adds JS file into a module
     *
     * @param string $file URL of a file
     * @param array $options options for given file
     *
     * @return $this
     */
    public function addFile($file, $options = []);

    /**
     * @return array a list of files and their options, indexed by filename
     */
    public function getFiles();

    /**
     * Clears all files from a module
     *
     * @return $this
     */
    public function clearFiles();

    /**
     * Adds dependency to a module
     *
     * @param ModuleInterface $depends an instance of another module which will is being added as dependency
     *
     * @return $this
     */
    public function addDependency(ModuleInterface $depends);

    /**
     * @return ModuleInterface[] a list of dependencies of a module
     */
    public function getDependencies();

    /**
     * Clears all dependencies from a module
     *
     * @return $this
     */
    public function clearDependencies();

    /**
     * @param array $options options for a module
     * @return $this
     */
    public function setOptions(array $options);

    /**
     * @return array a list of assigned options
     */
    public function getOptions();
}
