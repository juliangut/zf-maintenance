<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Provider;

/**
 * File presence maintenance provider.
 *
 * If file exists maintenance mode is considered to be On.
 */
class FileProvider extends AbstractProvider
{
    /**
     * {@inheritDoc}
     */
    protected $maintenanceDescription = 'File maintenance mode active on Jgut\Zf\Maintenance\Provider\FileProvider';

    /**
     * File path.
     *
     * @var string
     */
    protected $file;

    /**
     * @param string $file
     * @return void
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritDoc}
     */
    public function isActive()
    {
        $file = realpath($this->file);

        return file_exists($file) && is_file($file);
    }
}
