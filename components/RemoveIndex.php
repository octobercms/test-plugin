<?php namespace October\Test\Components;

use Str;
use Url;
use Redirect;
use Cms\Classes\ComponentBase;

/**
 * RemoveIndex
 */
class RemoveIndex extends ComponentBase
{
    /**
     * componentDetails
     */
    public function componentDetails()
    {
        return [
            'name' => 'Remove Index',
            'description' => 'This component removes the index.php part of the URL'
        ];
    }

    /**
     * onRun component
     */
    public function onRun()
    {
        $haveUrl = Url::full();

        $wantUrl = $this->removeIndex($haveUrl);

        if ($haveUrl !== $wantUrl) {
            return Redirect::to($wantUrl, 301);
        }
    }

    /**
     * removeIndex php file from a path.
     */
    protected function removeIndex(string $root): string
    {
        $i = 'index.php';

        return Str::contains($root, $i) ? str_replace('/'.$i, '', $root) : $root;
    }
}
