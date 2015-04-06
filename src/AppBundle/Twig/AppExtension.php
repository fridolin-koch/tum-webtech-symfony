<?php
namespace AppBundle\Twig;

use FKSE\Utilities\DateTimeUtil;

/**
 * Class AppExtension
 *
 * @author Fridolin Koch <info@fridokoch.de>
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('format_seconds', [$this, 'formatSecondsFilter'])
        ];
    }

    /**
     * @param int $value Some amount of seconds
     *
     * @return string Human readable representation of $value
     */
    public function formatSecondsFilter($value)
    {
        return DateTimeUtil::formatSeconds($value);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app_extension';
    }
}
