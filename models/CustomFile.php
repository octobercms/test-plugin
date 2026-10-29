<?php namespace October\Test\Models;

use Request;
use System\Models\File as FileBase;

/**
 * CustomFile tests a custom storage location without partition directories in storage/temp/public, which is cache storage, so real code should use a persistent public disk.
 */
class CustomFile extends FileBase
{
    /**
     * getPartitionDirectory returns the root, so files are not stored in partition directories.
     */
    protected function getPartitionDirectory()
    {
        return '/';
    }

    /**
     * getLocalRootPath returns the storage path as the root for local files.
     */
    protected function getLocalRootPath()
    {
        return storage_path();
    }

    /**
     * getStorageDirectory returns the directory inside the local root path, which the stock .htaccess serves publicly.
     */
    public function getStorageDirectory()
    {
        return 'temp/public/test-plugin-custom-files';
    }

    /**
     * getPublicPath returns the public URL path to the storage directory.
     */
    public function getPublicPath()
    {
        return Request::getBasePath() . '/storage/temp/public/test-plugin-custom-files';
    }

    /**
     * isLocalStorage always uses local storage, ignoring the configured disk.
     */
    protected function isLocalStorage()
    {
        return true;
    }
}
